<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BudgetTemplate;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
            'page_name' => 'budgets',
            'title' => 'Budget Templates',
            'templates' => BudgetTemplate::getTemplates(),
        ];
        return view('budgets.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'budgets',
            'title' => 'Add New Budget Template',
            'branches' => Admin::getBranches(),
            'years' => Admin::getBudgetYears()
        ];
        return view('budgets.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'temp_link' => [
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'year' => [
                'required',
                'integer',
            ],
        ]);

        $user_id = $request->input('user_id');
        $year = $request->input('year');
        $financial_year = Admin::getBudgetYearById($year)->financial_year;

        if(BudgetTemplate::getTemplateByUserAndYear($user_id, $year))
        return back()->with('danger', 'User has already been assigned with the budget');
        
        //return $request;
        $template = new BudgetTemplate();
        $template->year = $year;
        $template->user_id = $user_id;
        $template->temp_link = $request->input('temp_link');
        $template->created_by = Auth::user()->id;
        $template->save();

        $user = User::getUserById($template->user_id);

        //Save audit trail
        $activity_type = 'Budget Creation';
        $description = 'Created new budget template for '.strtoupper($user->name).' for the financial year '.$financial_year;
        User::saveAuditTrail($activity_type, $description);

        //Send message to user
        $message = new Message();
        $systemMessage = 'Your have a new budget template assigned to you for the financial year '.$financial_year.' Login to the Staffportal via staffportal.bimaskenya.com to view your template. ';
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);

        //$message->sendSms($mobileNo, $systemMessage);

        return back()->with('success', 'Budget template successfully saved for the selected user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'Helloo World';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageData = [
			'page_name' => 'budgets',
            'title' => 'Edit Budget Template',
            'branches' => Admin::getBranches(),
            'years' => Admin::getBudgetYears(),
            'budget' => BudgetTemplate::getTemplateById($id)
        ];
        return view('budgets.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'temp_link' => [
                'required',
            ],
        ]);


        //return $request;
        $template = BudgetTemplate::find($id);
        $template->temp_link = $request->input('temp_link');
        $template->created_by = Auth::user()->id;
        $template->save();

        $user = User::getUserById($template->user_id);

        //Save audit trail
        $activity_type = 'Budget Updation';
        $description = 'Updated budget template for '.strtoupper($user->name);
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Budget template successfully updated for the selected user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BudgetTemplate::find($id)->delete();

        //Save audit trail
        $activity_type = 'Budegt Template Deletion';
        $description = 'Successfully deleted budget template ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Budget template data successfully deleted');
    }
}