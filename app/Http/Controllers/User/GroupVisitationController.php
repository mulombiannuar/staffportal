<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appraisal;
use App\Models\Followup;
use App\Models\GroupVisitation;
use App\Models\GroupVisitationLoan;
use App\Models\GroupVisitationMember;
use App\Models\LoanRecovery;
use App\Models\User;
use App\Models\UserExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupVisitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'groups' => [
                'required', 
                'array', 
            ],
            'amount_collected' => [
                'required',
                'string',
            ],
            'date' => [
                'required',
                'string',
            ],
            'transport_means' => [
                'required',
                'integer',
            ],
            'amount_spent' => [
                'required',
                'string',
            ],
            'attachment' => [
                'nullable',
                'mimes:pdf', 
                'nullable', 
                'max:20000'
            ],
            'motor_regno' => [
                'nullable',
                'string',
            ],
            'mileage_before' => [
                'nullable',
                'string',
            ],
            'mileage_after' => [
                'nullable',
                'string',
            ],
            'fuel_consumption' => [
                'nullable',
                'string',
            ],
            'loans_applied' => [
                'required',
                'string',
            ],
            'new_members' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],
            'journey_from' => [
                'required',
                'string',
            ],
            'starting_time' => [
                'required',
                'string',
            ],
            'ending_time' => [
                'required',
                'string',
            ],
            'new_members' => [
                'required',
                'string',
            ],
            'amount_collected' => [
                'required',
                'string',
            ],
        ]);
        $expense_id = $request->input('expense_id');

        //RELAXED THIS MEASURE TO ADD MANY GROUP VISIT 
        // $expenseExists = GroupVisitation::where('expense_id', $expense_id)->first();
        // if( $expenseExists)
        // return back()->with('danger', 'The group visit expense activity of that specification already exists');

        if($request->hasFile('attachment')) 
        {
            $fileNameWithExt = $request->file('attachment')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('attachment')->getClientOriginalExtension();
            
            $attachment = $fileName.'_'.time().'.'.$extension;

            $request->file('attachment')->storeAs('public/assets/docs', $attachment);
        }
        else
        {
            $attachment = 'nopdf.pdf';
        }

        $groupVisit = new GroupVisitation();
        $groupVisit->expense_id = $expense_id;
        $groupVisit->attachment = $attachment;
        $groupVisit->groups = $request->input('groups');
        $groupVisit->date = $request->input('date');
        $groupVisit->transport_means = $request->input('transport_means');
        $groupVisit->journey_from = $request->input('journey_from');
        $groupVisit->start_time = $request->input('starting_time');
        $groupVisit->end_time = $request->input('ending_time');
        $groupVisit->amount_spent = $request->input('amount_spent');
        $groupVisit->motor_regno = $request->input('motor_regno');
        $groupVisit->mileage_before = $request->input('mileage_before');
        $groupVisit->mileage_after = $request->input('mileage_after');
        $groupVisit->fuel_consumption = $request->input('fuel_consumption');
        $groupVisit->loans_applied = $request->input('loans_applied');
        $groupVisit->new_members = $request->input('new_members');
        $groupVisit->amount_collected = $request->input('amount_collected');
        $groupVisit->additional_info = $request->input('additional_info');
        $groupVisit->save();

        //Save audit trail
        $activity_type = 'Group Visit Creation';
        $description = 'Successfully created new group visitation details ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //return $request;
        $request->validate([
            'groups' => [
                'required', 
                'array', 
            ],
            'date' => [
                'required',
                'string',
            ],
         
            'amount_spent' => [
                'required',
                'string',
            ],
            'attachment' => [
                'nullable',
                'mimes:pdf', 
                'nullable', 
                'max:20000'
            ],
            'motor_regno' => [
                'nullable',
                'string',
            ],
            'mileage_before' => [
                'nullable',
                'string',
            ],
            'mileage_after' => [
                'nullable',
                'string',
            ],
            'fuel_consumption' => [
                'nullable',
                'string',
            ],
            'loans_applied' => [
                'required',
                'string',
            ],
            'new_members' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],
            'amount_collected' => [
                'required',
                'string',
            ],
            'journey_from' => [
                'required',
                'string',
            ],
            'starting_time' => [
                'required',
                'string',
            ],
            'ending_time' => [
                'required',
                'string',
            ],
            'new_members' => [
                'required',
                'string',
            ],
        ]);
       
        $groupVisit = GroupVisitation::find($id);
        if($request->hasFile('attachment')) 
        {
            Storage::delete('public/assets/docs/'.$groupVisit->attachment);
            
            $fileNameWithExt = $request->file('attachment')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('attachment')->getClientOriginalExtension();
            
            $attachment = $fileName.'_'.time().'.'.$extension;

            $request->file('attachment')->storeAs('public/assets/docs', $attachment);
        }
        else
        {
            $attachment = $groupVisit->attachment;
        }

        $groupVisit->attachment = $attachment;
        $groupVisit->groups = $request->input('groups');
        $groupVisit->date = $request->input('date');
        $groupVisit->amount_spent = $request->input('amount_spent');
        $groupVisit->motor_regno = $request->input('motor_regno');
        $groupVisit->mileage_before = $request->input('mileage_before');
        $groupVisit->mileage_after = $request->input('mileage_after');
        $groupVisit->journey_from = $request->input('journey_from');
        $groupVisit->start_time = $request->input('starting_time');
        $groupVisit->end_time = $request->input('ending_time');
        $groupVisit->fuel_consumption = $request->input('fuel_consumption');
        $groupVisit->loans_applied = $request->input('loans_applied');
        $groupVisit->new_members = $request->input('new_members');
        $groupVisit->amount_collected = $request->input('amount_collected');
        $groupVisit->additional_info = $request->input('additional_info');
        $groupVisit->save();

        //Save audit trail
        $activity_type = 'Group Visit Updation';
        $description = 'Successfully updated group visitation details ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // GroupVisitationLoan::where('visit_id', $id)->first()->delete();
        // GroupVisitationMember::where('visit_id', $id)->first()->delete();
        
        GroupVisitation::find($id)->delete();

        //Save audit trail
        $activity_type = 'Group Visit Deleted';
        $description = 'Successfully deleted group visitation details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.index'))->with('success', 'Group visitation deleted successfully');
    }

    public function filePreview($id)
    {
        $attachment = '';
        $userExpense = UserExpense::find($id);
        if ($userExpense->activity_type == 1) {
           $attachment = GroupVisitation::where('expense_id', $id)->first()->attachment;
        } elseif($userExpense->activity_type == 2) {
            $attachment = Appraisal::where('expense_id', $id)->first()->attachment;
        }elseif($userExpense->activity_type == 3) {
            $attachment = LoanRecovery::where('expense_id', $id)->first()->attachment;
        }else{
            $attachment = Followup::where('expense_id', $id)->first()->attachment;
        }
        return $attachment;
        $groupVisit = GroupVisitation::where('expense_id', $id)->first();
        $pageData = [
            'attachment' => $attachment,
            'title' => 'Document Preview',
            'page_name' => 'groups',
        ];
        return view('user.group_visit_file_preview', $pageData);
    }

    public function saveClientLoan(Request $request)
    {
        $request->validate([
            'client' => 'required|string',
            'loan_product' => 'required',
            'loan_amount' => 'required',
            'loan_product' => 'required',
        ]);

        $clientData = $request->input('client');
        $clientString = explode('%', $clientData);
        $loan = new GroupVisitationLoan();
        $loan->visit_id = $request->input('visit_id');
        $loan->loan_product = $request->input('loan_product');
        $loan->loan_amount = $request->input('loan_amount');
        $loan->client_id = $clientString[0];
        $loan->client_name = $clientString[1];;
        $loan->save();

        //Save audit trail
        $activity_type = 'Group Client Loan Creation';
        $description = 'Successfully created new client loan '.$clientString[1];
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation member loan saved successfully');
    }

    public function updateClientLoan(Request $request, $id)
    {
        $request->validate([
            'loan_amount' => 'required',
            'loan_product' => 'required',
        ]);

        $loan = GroupVisitationLoan::find($id);
        $loan->loan_product = $request->input('loan_product');
        $loan->loan_amount = $request->input('loan_amount');
        $loan->save();

        //Save audit trail
        $activity_type = 'Group Client Loan Updation';
        $description = 'Updated loan for the group client ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation member loan updated successfully');
    }


    public function deleteClientLoan($id)
    {
        GroupVisitationLoan::find($id)->delete();

        //Save audit trail
        $activity_type = 'Group Client Loan Deletion';
        $description = 'Deleted loan for the group client ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation member loan deleted successfully');
    }

    public function saveMember(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_id' => 'required',
            'client_phone' => 'required',
            'group_code' => 'required',
            'activity_type' => 'required',
            'visit_id' => 'required',
        ]);

        $member = new GroupVisitationMember();
        $member->visit_id = $request->input('visit_id');
        $member->activity_type = $request->input('activity_type');
        $member->client_phone = $request->input('client_phone');
        $member->client_id = $request->input('client_id');;
        $member->client_name =$request->input('client_name');;
        $member->group_code =$request->input('group_code');;
        $member->save();

        //Save audit trail
        $activity_type = 'Group Client Client Creation';
        $description = 'Created new group member '. $member->client_name. ' for the group '. $member->group_code ;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'New group member saved successfully');
    }

    public function updateMember(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_id' => 'required',
            'client_phone' => 'required',
            'group_code' => 'required',
        ]);

        $member = GroupVisitationMember::find($id);
        $member->client_phone = $request->input('client_phone');
        $member->client_id = $request->input('client_id');;
        $member->client_name =$request->input('client_name');;
        $member->group_code =$request->input('group_code');;
        $member->save();

       //Save audit trail
       $activity_type = 'Group Client Client Updation';
       $description = 'Updated group member '. $member->client_name. ' for the group '. $member->group_code ;
       User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group member data updated successfully');
    }

    public function deleteMember($id)
    {
        GroupVisitationMember::find($id)->delete();

        //Save audit trail
        $activity_type = 'Group Client Member deletion';
        $description = 'Deleted member for the group ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Group visitation member deleted successfully');
    }

}