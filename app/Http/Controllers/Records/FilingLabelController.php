<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Records\ClientChangeForm;
use App\Models\Records\FilingLabel;
use App\Models\Records\LoanForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilingLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return FilingLabel::getFilingTypes();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Records Files Management',
            'filing_types' => FilingLabel::getFilingTypes()
        ];
        return view('records.filings.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'file_type' => 'required|integer',
            'label' => 'required|string'
        ]);

        $number = $request->number;

        if ($number < 1) 
        return back()->with('danger', 'The value you have entered must be greater than  one (1)');
        
        $file_type = $request->file_type;
        $label = $request->label;
        $filingType = DB::table('filing_types')->where('type_id', $file_type)->first();
        
        $beginningNumber = 1;
       
        $highestRecord =  $this->returnLastRecord($file_type);
        if ($highestRecord) {
            $beginningNumber = $highestRecord->file_number + $beginningNumber;
        }
       
        $pageData = [
            'label' => $label,
            'number' => $number,
			'page_name' => 'records',
            'filingType' => $filingType,
            'beginningNumber' => $beginningNumber,
            'title' => $filingType->type_name.' Files Management',
            'filing_types' => FilingLabel::getFilingTypes()
        ];
        return view('records.filings.create', $pageData);
    }

    private function returnLastRecord($file_type)
    {
        $highestRecord = [];
        $data = DB::table('filing_labels')->select('file_label', 'file_number')
                  ->where('file_type', $file_type)
                  ->orderBy('label_id', 'desc')->get();
        if (count($data) != 0) 
        $highestRecord = $data[0];

        return $highestRecord;
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
            'file_number' => 'required|array',
            'file_label' => 'required|array',
            'file_type' => 'required|integer',
        ]);

        $file_labels = $request->file_label;
        $file_numbers = $request->file_number;
        $file_type = $request->file_type;

        $filingType = DB::table('filing_types')->where('type_id', $file_type)->first();

        for ($s=0; $s <count($file_labels) ; $s++) { 
           DB::table('filing_labels')->insert([
                'file_type' => $file_type,
                'file_label' => $file_labels[$s],
                'file_number' => $this->formatFileNumber($file_numbers[$s]),
                'created_at' => now()
           ]);
        }

        //Save audit trail
        $activity_type = 'File labels creation';
        $description = 'Successfully created new file labels for '.$filingType->type_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.filing-labels.index'))->with('success', 'Successfully created new file labels for '.$filingType->type_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = FilingLabel::getLabelById($id);
        //return LoanForm::getLoanFormsByFileNumber($id);
        $pageData = [
            'file' => $file,
			'page_name' => 'records',
            'filing_label' => FilingLabel::getLabelById($id),
            'loan_forms' => $file->file_type == 7 
                         ? ClientChangeForm::getClientChangeFormsByFileLabel($id) 
                         : LoanForm::getLoanFormsByFileNumber($id),
            'title' => $file->type_name.' - '.$file->file_label.$file->file_number
        ];
        return view('records.filings.show', $pageData);
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
            'file_number' => 'required|string',
            'file_label' => 'required|string',
            'label_id' => 'required|integer',
        ]);

        $label = FilingLabel::find($id);
        $label->file_label = $request->file_label;
        $label->file_number = $this->formatFileNumber($request->file_number);
        $label->save();

        //Save audit trail
        $activity_type = 'File labels Updation';
        $description = 'Successfully updated file label '.$label->file_label.$label->file_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.filing-labels.show', $id))->with('success', 'Successfully updated file label '.$label->file_label.$label->file_number);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loanFormsCount = LoanForm::where('file_number', $id)->count();
        if ($loanFormsCount > 0) 
        return redirect(route('records.filing-labels.show', $id))->with('danger', 'You cannot delete this file since it already contains loan forms');
        
        FilingLabel::destroy($id);

        //Save audit trail
        $activity_type = 'File Lable Deletion';
        $description = 'Deleted file label successfully of the id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted File label successfully');
    }

    private function formatFileNumber($number)
    {
        return str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
