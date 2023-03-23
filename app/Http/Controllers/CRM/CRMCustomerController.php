<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CRM\CRMCustomer;
use App\Models\CRM\CustomerTicket;
use App\Models\CRM\TicketWorkflow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CRMCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return CRMCustomer::getCustomers();
        $pageData = [
			'page_name' => 'crm',
            'title' => 'CRM Module Customers',
            'customers' => CRMCustomer::getCustomers(),
        ];
        return view('crm.customer.index', $pageData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageData = [
			'page_name' => 'crm',
            'title' => 'Customer Details',
            'customer' => CRMCustomer::getCustomerById($id),
            'tickets' => CustomerTicket::getCustomerTicketsById($id),
        ];
        return view('crm.customer.show', $pageData);
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
			'page_name' => 'crm',
            'title' => 'Update Customer Data',
            'customer' => CRMCustomer::getCustomerById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('crm.customer.edit', $pageData);
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
            'customer_phone' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'customer_name' => [
                'required',
                'string'
            ],
            'residence' => [
                'required',
            ],
            'business' => [
                'required',
            ],
            'branch' => 'integer|required',
            'outpost_id' => 'integer|required',
        ]);

        $bimas_br_id = null;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone; 
        $residence = $request->residence; 
        $business = $request->business;
        $branch = $request->branch;
        $outpost = $request->outpost_id;

        $customerTicket = new CustomerTicketController();
        $clientData = CRMCustomer::getClientByMobileNumber($customer_phone);
        if($clientData) $bimas_br_id = $clientData->bimas_br_id;

        //Update and get details of client
        $customerData = $customerTicket->updateCustomer($id, $customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id);

        //Save audit trail
        $activity_type = 'Customer Details Updation';
        $description = 'Successfully updated customer '.$customerData->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('crm.customers.index'))->with('success', 'Successfully updated customer '.$customerData->customer_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CRMCustomer::destroy($id);
        
        //Save audit trail
        $activity_type = 'Customer Deletion';
        $description = 'Deleted customer of the id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Customer Successfully');
    }

    public function workflows()
    {
        $pageData = [
			'page_name' => 'crm',
            'title' => 'CRM Workflow Levels',
            'workflows' => TicketWorkflow::getCRMWorkflowUsers(),
        ];
        return view('crm.workflows', $pageData);
    }
}
