<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoanRecovery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoanRecoveryController extends Controller
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
            'client_name' => [
                'required', 
                'string', 
            ],
            'client_id' => [
                'required', 
                'string', 
            ],
            'client_phone' => [
                'required', 
                'string', 
            ],
            'client_id' => [
                'required', 
                'string', 
            ],
            'client_phone' => [
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
            'venue' => [
                'required',
                'string',
            ],
            'amount_collected' => [
                'required',
                'string',
            ],
        ]);

        $expense_id = $request->input('expense_id');
        $recoveryExists = LoanRecovery::where('expense_id', $expense_id)->first();
        if( $recoveryExists)
        return back()->with('danger', 'The recovery expense activity of that specification already exists');

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

        $recovery = new LoanRecovery();
        $recovery->expense_id = $expense_id;
        $recovery->attachment = $attachment;
        $recovery->client_name = $request->input('client_name');
        $recovery->client_phone = $request->input('client_phone');
        $recovery->client_id = $request->input('client_id');
        $recovery->date = $request->input('date');
        $recovery->venue = $request->input('venue');
        $recovery->transport_means = $request->input('transport_means');
        $recovery->journey_from = $request->input('journey_from');
        $recovery->start_time = $request->input('starting_time');
        $recovery->end_time = $request->input('ending_time');
        $recovery->amount_spent = $request->input('amount_spent');
        $recovery->amount_collected = $request->input('amount_collected');
        $recovery->motor_regno = $request->input('motor_regno');
        $recovery->mileage_before = $request->input('mileage_before');
        $recovery->mileage_after = $request->input('mileage_after');
        $recovery->fuel_consumption = $request->input('fuel_consumption');
        $recovery->additional_info = $request->input('additional_info');
        $recovery->save();

        //Save audit trail
        $activity_type = 'Recovery Expense Creation';
        $description = 'Successfully created new recovery expense details dated '.$recovery->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'recovery details saved successfully');
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
        $request->validate([
            'client_name' => [
                'required', 
                'string', 
            ],
            'client_id' => [
                'required', 
                'string', 
            ],
            'client_phone' => [
                'required', 
                'string', 
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
            'venue' => [
                'required',
                'string',
            ],
            'amount_collected' => [
                'required',
                'string',
            ],
        ]);

        $expense_id = $request->input('expense_id');
        $recovery = LoanRecovery::find($id);

        $recoveryExists = LoanRecovery::where('expense_id', $expense_id)->first();
        if( $recoveryExists)
        return back()->with('danger', 'The recovery expense activity of that specification already exists');

        if($request->hasFile('attachment')) 
        {
            Storage::delete('public/assets/docs/'.$recovery->attachment);

            $fileNameWithExt = $request->file('attachment')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('attachment')->getClientOriginalExtension();
            
            $attachment = $fileName.'_'.time().'.'.$extension;

            $request->file('attachment')->storeAs('public/assets/docs', $attachment);
        }
        else
        {
            $attachment = $recovery->attachment;
        }

        $recovery->attachment = $attachment;
        $recovery->client_name = $request->input('client_name');
        $recovery->client_phone = $request->input('client_phone');
        $recovery->client_id = $request->input('client_id');
        $recovery->date = $request->input('date');
        $recovery->venue = $request->input('venue');
        $recovery->journey_from = $request->input('journey_from');
        $recovery->start_time = $request->input('starting_time');
        $recovery->end_time = $request->input('ending_time');
        $recovery->amount_spent = $request->input('amount_spent');
        $recovery->amount_collected = $request->input('amount_collected');
        $recovery->motor_regno = $request->input('motor_regno');
        $recovery->mileage_before = $request->input('mileage_before');
        $recovery->mileage_after = $request->input('mileage_after');
        $recovery->fuel_consumption = $request->input('fuel_consumption');
        $recovery->additional_info = $request->input('additional_info');
        $recovery->save();

        //Save audit trail
        $activity_type = 'Recovery Expense Updation';
        $description = 'Successfully updated recovery expense details dated '.$recovery->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'recovery details updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanRecovery::find($id)->delete();

        //Save audit trail
        $activity_type = 'Loan Recovery Expense Deletion';
        $description = 'Successfully deleted group visitation details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.index'))->with('success', 'Loan Recovery Expense data deleted successfully');
    }
}