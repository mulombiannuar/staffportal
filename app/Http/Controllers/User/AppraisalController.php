<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appraisal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppraisalController extends Controller
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
        $appraisalExists = Appraisal::where('expense_id', $expense_id)->first();
        if( $appraisalExists)
        return back()->with('danger', 'The Appraisal expense activity of that specification already exists');

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

        $appraisal = new Appraisal();
        $appraisal->expense_id = $expense_id;
        $appraisal->attachment = $attachment;
        $appraisal->clients = $request->input('clients');
        $appraisal->date = $request->input('date');
        $appraisal->venue = $request->input('venue');
        $appraisal->transport_means = $request->input('transport_means');
        $appraisal->journey_from = $request->input('journey_from');
        $appraisal->start_time = $request->input('starting_time');
        $appraisal->end_time = $request->input('ending_time');
        $appraisal->amount_spent = $request->input('amount_spent');
        $appraisal->motor_regno = $request->input('motor_regno');
        $appraisal->mileage_before = $request->input('mileage_before');
        $appraisal->mileage_after = $request->input('mileage_after');
        $appraisal->fuel_consumption = $request->input('fuel_consumption');
        $appraisal->additional_info = $request->input('additional_info');
        $appraisal->save();

        //Save audit trail
        $activity_type = 'Appraisal Expense Creation';
        $description = 'Successfully created new appraisal expense details dated '.$appraisal->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Appraisal details saved successfully');
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
        $appraisal = Appraisal::find($id);

        if($request->hasFile('attachment')) 
        {
            Storage::delete('public/assets/docs/'.$appraisal->attachment);

            $fileNameWithExt = $request->file('attachment')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('attachment')->getClientOriginalExtension();
            
            $attachment = $fileName.'_'.time().'.'.$extension;

            $request->file('attachment')->storeAs('public/assets/docs', $attachment);
        }
        else
        {
            $attachment = $appraisal->attachment;
        }

        $appraisal->attachment = $attachment;
        $appraisal->clients = $request->input('clients');
        $appraisal->date = $request->input('date');
        $appraisal->venue = $request->input('venue');
        $appraisal->journey_from = $request->input('journey_from');
        $appraisal->start_time = $request->input('starting_time');
        $appraisal->end_time = $request->input('ending_time');
        $appraisal->amount_spent = $request->input('amount_spent');
        $appraisal->motor_regno = $request->input('motor_regno');
        $appraisal->mileage_before = $request->input('mileage_before');
        $appraisal->mileage_after = $request->input('mileage_after');
        $appraisal->fuel_consumption = $request->input('fuel_consumption');
        $appraisal->additional_info = $request->input('additional_info');
        $appraisal->save();

        //Save audit trail
        $activity_type = 'Appraisal Expense Updation';
        $description = 'Successfully updated appraisal expense details dated '.$appraisal->date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Appraisal details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appraisal::find($id)->delete();

        //Save audit trail
        $activity_type = 'Appraisal Expense Deletion';
        $description = 'Successfully deleted appraisal details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.index'))->with('success', 'Appraisal data deleted successfully');
    }
}