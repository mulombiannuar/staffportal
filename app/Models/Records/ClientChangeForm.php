<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientChangeForm extends Model
{
    use HasFactory;
    protected $table = 'client_change_forms';
    protected $primaryKey = 'form_id'; 

    public static function getClientChangeFormById($id)
    {
        return ClientChangeForm::join('clients', 'clients.client_id', '=', 'client_change_forms.client_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'client_change_forms.file_number')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'client_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'file_label',
                        'label_id',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('form_id', $id)
                    ->first();
    }

    public static function getClientChangeForms()
    {
        return ClientChangeForm::join('users', 'users.id', '=', 'client_change_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'client_change_forms.client_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'client_change_forms.file_number')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'client_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'file_label',
                        'users.name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->orderBy('form_id', 'desc')
                    ->get();
    }

    public static function getClientChangeFormsByFileLabel($file_label)
    {
        return ClientChangeForm::join('clients', 'clients.client_id', '=', 'client_change_forms.client_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'client_change_forms.file_number')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'client_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'file_label',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('client_change_forms.file_number', $file_label)
                    ->orderBy('form_id', 'desc')
                    ->get();
    }

    public static function getRequestedChangeForm($bimas_br_id, $date_changed)
    {
        return DB::table('client_change_forms')
                 ->join('clients', 'clients.client_id', '=', 'client_change_forms.client_id')
                 ->join('requested_change_forms', 'requested_change_forms.bimas_br_id', '=', 'clients.bimas_br_id')
                 ->where([
                    'requested_change_forms.bimas_br_id' => $bimas_br_id, 
                    'client_change_forms.date_changed' => $date_changed
                    ])
                 ->first();
    }

    public static function getClientChangeFormsByDateRanges($start_date, $end_date)
    {
        return ClientChangeForm::join('users', 'users.id', '=', 'client_change_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'client_change_forms.client_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'client_change_forms.file_number')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'client_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'file_label',
                        'users.name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('client_change_forms.created_at', '>=', $start_date)
                    ->where('client_change_forms.created_at', '<=', $end_date)
                    ->orderBy('form_id', 'desc')
                    ->get();
    }

}
