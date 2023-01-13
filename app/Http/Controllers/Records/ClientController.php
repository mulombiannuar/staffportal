<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Records\Client;
use App\Models\Records\RequestedChangeForm;
use App\Models\Records\RequestedLoanForm;
use App\Models\User;
use App\Utilities\Buttons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'records',
            'title' => 'Clients Management',
            'clients' => []
        ];
        return view('records.clients.index', $pageData);
    }

    public function getClients()
    {
        $clients = Client::getClients();
        return Datatables::of($clients)
                        ->addIndexColumn()
                        ->addColumn('action', function ($client) {
                            return Buttons::dataTableButtons(
                                route('records.clients.show', $client->client_id),
                                route('records.clients.edit', $client->client_id),
                                route('records.clients.destroy', $client->client_id),
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
            'title' => 'Add New Client',
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.clients.create', $pageData);
    }

    public function createClientUsingLoanRequest($request_id)
    {
        $form = new RequestedLoanForm();
        $clientLoanData = $form->getLoanFormRequestById($request_id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Add New Client',
            'client' => $clientLoanData,
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.clients.create_loan_client', $pageData);
    }

    public function createClientUsingChangeFormRequest($request_id)
    {
        $clientChangeData = RequestedChangeForm::getChangeFormRequestById($request_id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Add New Client',
            'client' => $clientChangeData,
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.clients.create_change_client', $pageData);
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
           'bimas_br_id' => 'required|string|digits:7|max:7|min:7|unique:clients,bimas_br_id',
           'client_phone' => 'required|digits:12|max:12|min:12|unique:clients,client_phone',
           'national_id' => 'required|string|max:255|unique:clients,national_id',
           'client_name' => 'required|string|max:255',
           'branch' => 'required|integer',
           'outpost' => 'required|integer',
        ]);

        $client = new Client();
        $client->bimas_br_id = $request->input('bimas_br_id');
        $client->client_phone = $request->input('client_phone');
        $client->client_name = $request->input('client_name');
        $client->national_id = $request->input('national_id');
        $client->branch_id = $request->input('branch');
        $client->outpost_id = $request->input('outpost');
        $client->created_by = Auth::user()->id;
        $client->save();

        //Save audit trail
        $activity_type = 'Record Client Registration';
        $description = 'Successfully created new records client '. $client->client_name;
        User::saveAuditTrail($activity_type, $description);

        //Send sms notification to the user
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);
        $outpost = Admin::getOutpostById($client->outpost_id);

        $systemMessage = 'you have successfully registered new records client '.strtoupper($client->client_name).' for '.$outpost->outpost_name. ' branch';
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
        $message->sendSms($mobileNo, $messageBody);
 
        $message->message_status = 'sent'; 
        $message->message_type = 'records_clients_creation'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        return redirect(route('records.clients.index'))->with('success', 'Successfully registered new records client '.$client->client_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::getClientById($id);
        $pageData = [
			'page_name' => 'records',
            'client' => $client,
            'loan-forms' => [],
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'title' => ucwords($client->client_name.' - '.$client->client_phone.'/'.$client->bimas_br_id),
        ];
        return view('records.clients.show', $pageData);
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
			'page_name' => 'records',
            'title' => 'Update Client Details',
            'client' => Client::getClientById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.clients.edit', $pageData);
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
            'bimas_br_id' => 'required|string|digits:7|max:7|min:7',
            'client_phone' => 'required|digits:12|max:12|min:12',
            'client_name' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'branch' => 'required|integer',
            'outpost' => 'required|integer',
         ]);

         $client = Client::find($id);
         $client->bimas_br_id = $request->input('bimas_br_id');
         $client->client_phone = $request->input('client_phone');
         $client->client_name = $request->input('client_name');
         $client->national_id = $request->input('national_id');
         $client->branch_id = $request->input('branch');
         $client->outpost_id = $request->input('outpost');
         $client->save();
 
         //Save audit trail
         $activity_type = 'Record Client Updation';
         $description = 'Successfully updated records client '. $client->client_name;
         User::saveAuditTrail($activity_type, $description);
 
         return redirect(route('records.clients.index'))->with('success', 'Successfully updated records client '.$client->client_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();

        //Save audit trail
        $activity_type = 'Records Client Deletion';
        $description = 'Deleted Records client successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Records client successfully');
    }
}
