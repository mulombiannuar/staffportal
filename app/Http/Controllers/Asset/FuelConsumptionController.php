<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\FuelConsumption;
use App\Models\Products\Motor;
use App\Models\User;
use App\Rules\MileageRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FuelConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fuel = new FuelConsumption();
        //return $license->getAssetlicenses();
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Fuel Consumption Data',
            'fuels' => $fuel->getConsumptions(),
        ];
        return view('assets.fuel.index', $pageData);
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
        $request->validate([
            'asset_id' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'string',
            ],
            'capacity' => [
                'required',
                'string',
            ],
            'current' => [
                'required',
                'string',
                new MileageRule($request->input('asset_id'))
            ],
            'file' => [
                'mimes:pdf', 
                'nullable', 
                'max:30000'],

        ]);

        if($request->hasFile('file')) 
        {
            $fileNameWithExt = $request->file('file')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('file')->getClientOriginalExtension();
            
            $userDoc = $fileName.'_'.time().'.'.$extension;

            $request->file('file')->storeAs('public/assets/docs', $userDoc);
        }
        else
        {
            $userDoc = 'nopdf.pdf';
        }

        $motor = Motor::find($request->input('asset_id'));
      
        $fuel = new FuelConsumption();
        $fuel->user_id = $request->input('user_id');
        $fuel->asset_id = $request->input('asset_id');
        $fuel->cost = $request->input('cost');
        $fuel->date = $request->input('date');
        $fuel->capacity = $request->input('capacity');
        $fuel->current = $request->input('current');
        $fuel->previous = $motor->mileage;
        $fuel->difference = $fuel->current - $fuel->previous;
        $fuel->action_by = Auth::user()->id;
        $fuel->file = $userDoc;
        $fuel->save();

        $motor->mileage = $fuel->current;
        $motor->save();

        //Save audit trail
        $activity_type = 'Fuel Consumption Creation';
        $description = 'Created new fuel consumption data for the asset id '.$motor->reg_no;
        User::saveAuditTrail($activity_type, $description);

       // return redirect(route('admin.licenses.index'))->with('success', 'Asset license data for the selected item successfully saved');
        return back()->with('success', 'Asset fuel consumption data successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fuel = new FuelConsumption();
         $pageData = [
             'page_name' => 'assets',
             'title' => 'Fuel Consumption Details ',
             'fuel' => $fuel->getConsumptionById($id),
         ];
         return view('assets.fuel.show', $pageData);
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
             'page_name' => 'assets',
             'title' => 'Edit Fuel Consumption Details ',
             'fuel' => FuelConsumption::find($id),
         ];
         return view('assets.fuel.edit', $pageData);
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
            'date' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'string',
            ],
            'capacity' => [
                'required',
                'string',
            ],
            'current' => [
                'required',
                'string',
            ],
            'file' => [
                'mimes:pdf', 
                'nullable', 
                'max:30000'],

        ]);
        //return $request;
        $fuel = FuelConsumption::find($id);
        $motor = Motor::find($fuel->asset_id);

        if($request->hasFile('file')) 
        {
            if ($fuel->file != 'nopdf.pdf') 
            Storage::delete('public/assets/docs/'.$fuel->file);
              
            $fileNameWithExt = $request->file('file')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('file')->getClientOriginalExtension();
            
            $userDoc = $fileName.'_'.time().'.'.$extension;

            $request->file('file')->storeAs('public/assets/docs', $userDoc);
        }
        else
        {
            $userDoc = $fuel->file;
        }

        $fuel->cost = $request->input('cost');
        $fuel->date = $request->input('date');
        $fuel->capacity = $request->input('capacity');
        $fuel->current = $request->input('current');
        $fuel->difference = $fuel->current - $fuel->previous;
        $fuel->action_by = Auth::user()->id;
        $fuel->file = $userDoc;
        $fuel->save();

        $motor->mileage = $fuel->current;
        $motor->save();

        //Save audit trail
        $activity_type = 'Fuel Consumption Updation';
        $description = 'Updated fuel consumption data for the asset id '.$motor->reg_no;
        User::saveAuditTrail($activity_type, $description);

       // return redirect(route('admin.licenses.index'))->with('success', 'Asset license data for the selected item successfully saved');
        return back()->with('success', 'Asset fuel consumption data for the selected item successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fuel = FuelConsumption::find($id);

        Storage::delete('public/assets/docs/'.$fuel->file);

        $fuel->delete();

        //Save audit trail
        $activity_type = 'Fuel Consumption Data Deletion';
        $description = 'Successfully deleted asset fuel consumption data ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset fuel consumption data successfully deleted');
    }
    
}