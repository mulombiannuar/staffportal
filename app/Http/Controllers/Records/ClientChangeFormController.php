<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Records\Client;
use App\Models\Records\ClientChangeForm;
use App\Models\Records\FilingLabel;
use App\Models\Records\RequestedChangeForm;
use App\Models\User;
use App\Utilities\Buttons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ClientChangeFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return RequestedChangeForm::getChangeFormRequests(0);
        $pageData = [
			'page_name' => 'records',
            'count' => ClientChangeForm::count(),
            'title' => 'Clients Change Forms ('.ClientChangeForm::count().')',
            'pendingRequests' => RequestedChangeForm::getChangeFormRequests(0),
            'completedRequests' => RequestedChangeForm::getChangeFormRequests(1)
        ];
        return view('records.change_forms.index', $pageData);
    }

    public function getChangeForms()
    {
        $forms = ClientChangeForm::getClientChangeForms();
        return DataTables::of($forms)
                        ->addIndexColumn()
                        ->addColumn('action', function ($form) {
                            return Buttons::dataTableButtons(
                                route('records.change-forms.show', $form->form_id),
                                route('records.change-forms.edit', $form->form_id),
                                route('records.change-forms.destroy', $form->form_id),
                            );
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'records',
            'title' => 'Add Change Forms',
            'filing_labels' => FilingLabel::getFilesByType('7'),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.change_forms.create', $pageData);
    }

    public function createChangeFormUsingOfficerRequest(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'request_id' => 'required|integer',
        ]);

        $formData = RequestedChangeForm::getChangeFormRequestById($request->request_id);
        //return Client::getClientBRId($request->client_id);

        $pageData = [
			'page_name' => 'records',
            'title' => 'Add New Change Form',
            'change_form' => $formData,
            'filing_labels' => FilingLabel::getFilesByType('7'),
            'client' => Client::getClientBRId($request->client_id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.change_forms.create_change_request', $pageData);
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
            'branch' => 'required|integer',
            'outpost_id' => 'required|integer',
            'clients' => 'required|integer',
            'file_label' => 'required|integer',
            'date_changed' => 'required|string|max:255',
            'change_form' => "required|mimes:pdf",
        ]);

         $client = Client::find($request->clients);
         $fileLabel = FilingLabel::find($request->file_label);

         $formName = $this->getFormName($client, $fileLabel, $request->date_changed); 

         $changeFormDocName = 'nopdf.pdf';
         if($request->hasFile('change_form')) 
         {
             $extension = $request->file('change_form')->getClientOriginalExtension();
             
             $changeFormDocName = $formName.'.'.$extension;
 
             $request->file('change_form')->storeAs('public/assets/change-forms', $changeFormDocName);
         }

         $form = new ClientChangeForm();
         $form->client_id = $client->client_id;
         $form->file_number = $request->file_label;
         $form->date_changed = $request->date_changed;
         $form->file_name = $changeFormDocName;
         $form->created_by = Auth::user()->id;
         $form->save();

         //Save audit trail
         $activity_type = 'Client Change Form Upload';
         $description = 'Successfully uploaded new client change form for '. $client->client_name;
         User::saveAuditTrail($activity_type, $description);

         return redirect(route('records.change-forms.index'))->with('success', 'Successfully uploaded new client change form for '.$client->client_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$form = new RequestedLoanForm();
        //return LoanForm::getLoanFormById($id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Change Form Details',
            'change_form' => ClientChangeForm::getClientChangeFormById($id),
            'change_forms' => [],
            //'change_forms' => $form->getLoanFormRequestByFormId($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.change_forms.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return ClientChangeForm::getClientChangeFormById($id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Update Change Form',
            'filing_labels' => FilingLabel::getFilesByType('7'),
            'change_form' => ClientChangeForm::getClientChangeFormById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.change_forms.edit', $pageData);
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
            'branch' => 'required|integer',
            'outpost_id' => 'required|integer',
            'clients' => 'required|integer',
            'file_label' => 'required|integer',
            'date_changed' => 'required|string|max:255',
            'change_form' => "nullable|mimes:pdf",
        ]);

        $client = Client::find($request->clients);
        $fileLabel = FilingLabel::find($request->file_label);

        $formName = $this->getFormName($client, $fileLabel, $request->date_changed); 

        $form = ClientChangeForm::find($id);
        $changeFormDocName = $form->file_name;
        
        if($request->hasFile('change_form')) 
        {
            Storage::delete('public/assets/change-forms/'.$changeFormDocName);

            $extension = $request->file('change_form')->getClientOriginalExtension();
            
            $changeFormDocName = $formName.'.'.$extension;

            $request->file('change_form')->storeAs('public/assets/change-forms', $changeFormDocName);
        }

        $form->client_id = $client->client_id;
        $form->file_number = $request->file_label;
        $form->date_changed = $request->date_changed;
        $form->file_name = $changeFormDocName;
        $form->save();

        //Save audit trail
        $activity_type = 'Client Change Form Updation';
        $description = 'Successfully updated client change form for '. $client->client_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.change-forms.index'))->with('success', 'Successfully updated client change form for'.$client->client_name);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = ClientChangeForm::find($id);
        Storage::delete('public/assets/change-forms/'.$form->file_name);
        $form->delete();

        //Save audit trail
        $activity_type = 'Change Form Deletion';
        $description = 'Successfully deleted loan with id '. $id;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.change-forms.index'))->with('success', 'Successfully deleted loan form with id '.$id);
    }

    private function getFormName($client, $fileLabel, $dateChanged)
    {
        return 'client-'.$client->bimas_br_id.
                      '-'.ucwords('Change-Form').
                      '-'.strtoupper($fileLabel->file_label.$fileLabel->file_number).
                      '-'.$dateChanged.
                      '-'.time();
    }
}
