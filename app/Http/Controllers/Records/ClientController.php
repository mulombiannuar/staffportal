<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Imports\ClientsDataImport;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Records\Client;
use App\Models\Records\LoanForm;
use App\Models\Records\RequestedChangeForm;
use App\Models\Records\RequestedLoanForm;
use App\Models\User;
use App\Utilities\Buttons;
use App\Utilities\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
        //return $this->saveCSVFileRawData('clients-15-03-2023.csv');
        //return $this->updateCSVRawData(); 

        $pageData = [
			'page_name' => 'records',
            'title' => 'Clients Management',
            'clients' => [],
            'excels' => LoanForm::getUploadedExcels('clients')
        ];
        return view('records.clients.index', $pageData);
    }

    public function getClients()
    {
        $clients = Client::getClients();
        return Datatables::of($clients)
                        ->addIndexColumn()
                        ->addColumn('name', function ($client) {
                            return Buttons::dataTableClientNameLink($client->client_id, $client->client_name);
                        })
                        ->rawColumns(['name'])
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
       // return LoanForm::getClientLoansByClientID($client->bimas_br_id);
        $pageData = [
			'page_name' => 'records',
            'client' => $client,
            'title' => ucwords($client->client_name.' - '.$client->bimas_br_id),
            'loan_forms' => RequestedLoanForm::getRequestedLoanFormsByClientID($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'client_loans' => LoanForm::getClientLoansByClientID($client->bimas_br_id),
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

    // function to save raw data from csv file to database
    public function saveCSVFileRawData($file_name)
    {
        $data = LoanFormController::getCSVFileArrayValues($file_name)['rows'];
        for ($s=0; $s <count($data) ; $s++) { 
            DB::table('clients2')->insert([
                'bimas_br_id' => $data[$s][0],
                'client_name' => ucwords($data[$s][3]),
                'client_phone' => $data[$s][5],
                'national_id' => $data[$s][6],
                'branch_id' => $data[$s][1],
                'outpost_id' => $data[$s][4],
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 

        return 'Data import completed successfully. '.count($data). ' records affected.';
    }

    // function to update raw data
    public function updateCSVRawData()
    {
        $clients = DB::table('clients3')->where('outpost_client', 1)->get();
        //return count($clients);
        for ($s=0; $s <count($clients) ; $s++) 
        { 
            $branch = 1;
            $outpost = 1;
            $outpostData = Admin::getOutpostByName(ucwords($clients[$s]->outpost_id));
            if (!is_null($outpostData)) {
                $outpost = $outpostData->outpost_id;
                $branch = $outpostData->outpost_branch_id;
            }
           
            DB::table('clients3')->where('client_id', $clients[$s]->client_id)->update([
                'branch_id' => $branch,
                'outpost_id' => $outpost
            ]);
        }

        return 'Data update completed successfully. '.count($clients). ' records affected.';
    }

    //function to import clients from excel file
    public function importExcelClients(Request $request)
    {
        $request->validate([
            'excel_file' => "required|mimes:xls,xlsx,csv", 
            'registration_date' => 'required|date'           
        ]);

        //Backup database first

         //Save excel file
         $excelFileName = 'clients-data-'.$request->registration_date.'-'.time();

         if($request->hasFile('excel_file')) 
         {
             $extension = $request->file('excel_file')->getClientOriginalExtension();
             
             $newExcelFileName = $excelFileName.'.'.$extension;
 
             $request->file('excel_file')->storeAs('public/assets/excels', $newExcelFileName);
         }

         try{
            // Get affected rows
            $excelData = (new ClientsDataImport)->toArray($request->excel_file);
            $affectedRows = count($excelData[0]);

            // Save import data
            $formattedDate = Utilities::formatDate($request->registration_date, 'Y-m-d'). ' 00:00:00';
            LoanForm::saveUploadedExcelData($formattedDate, $newExcelFileName, $affectedRows, 'clients');
        
            Excel::import(new ClientsDataImport, $request->excel_file);

            //Save audit trail
            $activity_type = 'Clients Data File Upload';
            $description = 'Successfully imported clients excel data for registration dated '. $request->registration_date;
            User::saveAuditTrail($activity_type, $description);

            return back()->with('success', 'Excel data imported successfully. '.$affectedRows.' rows affected');
        }
        catch(\Throwable $th){
           
            DB::rollback();
             
            // Save import data
            $affectedRows = 0;
            $formattedDate = Utilities::formatDate($request->registration_date, 'Y-m-d'). ' 00:00:00';
            LoanForm::saveUploadedExcelData($formattedDate, $newExcelFileName, $affectedRows, 'loans');

            return back()->with('danger', 'Excel data could not be imported successfully. '.$th->getMessage());
        }

    }
}
