<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Followup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FollowupController extends Controller
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
            'clients' => [
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
            'amount_collected' => [
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
        ]);

        $expense_id = $request->input('expense_id');
        $followupExists = Followup::where('expense_id', $expense_id)->first();
        if( $followupExists)
        return back()->with('danger', 'The followup expense activity of that specification already exists');

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

        $followup = new Followup();
        $followup->expense_id = $expense_id;
        $followup->attachment = $attachment;
        $followup->clients = $request->input('clients');
        $followup->date = $request->input('date');
        $followup->venue = $request->input('venue');
        $followup->transport_means = $request->input('transport_means');
        $followup->journey_from = $request->input('journey_from');
        $followup->start_time = $request->input('starting_time');
        $followup->end_time = $request->input('ending_time');
        $followup->amount_spent = $request->input('amount_spent');
        $followup->amount_collected = $request->input('amount_collected');
        $followup->motor_regno = $request->input('motor_regno');
        $followup->mileage_before = $request->input('mileage_before');
        $followup->mileage_after = $request->input('mileage_after');
        $followup->fuel_consumption = $request->input('fuel_consumption');
        $followup->additional_info = $request->input('additional_info');
        $followup->save();

        //Save audit trail
        $activity_type = 'Followup Expense Creation';
        $description = 'Successfully created new followup expense details dated '.$followup->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'followup details saved successfully');
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
            'clients' => [
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
            'amount_collected' => [
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
        ]);

        $followup = Followup::find($id);

        if($request->hasFile('attachment')) 
        {
            Storage::delete('public/assets/docs/'.$followup->attachment);

            $fileNameWithExt = $request->file('attachment')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('attachment')->getClientOriginalExtension();
            
            $attachment = $fileName.'_'.time().'.'.$extension;

            $request->file('attachment')->storeAs('public/assets/docs', $attachment);
        }
        else
        {
            $attachment = $followup->attachment;
        }

        $followup->attachment = $attachment;
        $followup->clients = $request->input('clients');
        $followup->date = $request->input('date');
        $followup->venue = $request->input('venue');
        $followup->journey_from = $request->input('journey_from');
        $followup->start_time = $request->input('starting_time');
        $followup->end_time = $request->input('ending_time');
        $followup->amount_spent = $request->input('amount_spent');
        $followup->amount_collected = $request->input('amount_collected');
        $followup->motor_regno = $request->input('motor_regno');
        $followup->mileage_before = $request->input('mileage_before');
        $followup->mileage_after = $request->input('mileage_after');
        $followup->fuel_consumption = $request->input('fuel_consumption');
        $followup->additional_info = $request->input('additional_info');
        $followup->save();

        //Save audit trail
        $activity_type = 'Followup Expense Updation';
        $description = 'Successfully updated followup expense details dated '.$followup->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Followup details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Followup::find($id)->delete();

        //Save audit trail
        $activity_type = 'Followup Expense Deletion';
        $description = 'Successfully deleted followup details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.index'))->with('success', 'Followup data deleted successfully');
    }
}