<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FilingLabel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'filing_labels';
    protected $primaryKey = 'label_id';
    
    public static function getFilingTypes()
    {
        $files = DB::table('filing_types')->orderBy('type_name', 'asc')->get();
        for ($s=0; $s <count($files) ; $s++) { 
            $files[$s]->labels = FilingLabel::getFilesByFilingType($files[$s]->type_id);
            $files[$s]->count =  count($files[$s]->labels) == 0 ? '0' : count($files[$s]->labels); //get nu
        }
        return $files;
    }

    public function getFilesByFilingType($type)
    {
        $labels = FilingLabel::getFilesByType($type);
        for ($s=0; $s <count($labels) ; $s++) { 
            $labels[$s]->count = count(LoanForm::where('file_number', $labels[$s]->label_id)->get());
            
            if ($labels[$s]->file_type == 7) 
            $labels[$s]->count = count(ClientChangeForm::where('file_number', $labels[$s]->label_id)->get());
           
        }
        return $labels;
    }

    public static function getLabelById($label_id)
    {
        return FilingLabel::join('filing_types', 'filing_types.type_id', '=', 'filing_labels.file_type')
                          ->where('label_id', $label_id)
                          ->select('filing_labels.*', 'filing_types.type_name')
                          ->first();
    }

    public static function getFilesByType($type)
    {
        return DB::table('filing_labels')->where('deleted_at', null)->select('label_id', 'file_type', 'file_label','file_number')->where('file_type', $type)->orderBy('file_number', 'asc')->get();
    }

}
