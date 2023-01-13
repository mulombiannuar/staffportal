<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestedChangeForm extends Model
{
    use HasFactory;
    protected $table = 'requested_change_forms';
    protected $primaryKey = 'request_id';

    public static function getChangeFormRequests($status)
    {
        return DB::table('requested_change_forms')
                 ->join('users', 'users.id', '=', 'requested_change_forms.requested_by')
                 ->join('branches', 'branches.branch_id', '=', 'requested_change_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_change_forms.outpost_id')
                 ->select(
                        'requested_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'name',
                        DB::raw('(
                            CASE 
                              WHEN is_original = "0" THEN "Electronic copy" 
                              ELSE "Original copy" 
                            END
                            ) AS form_type'))
                 ->where('is_completed', $status)
                 ->orderBy('request_id', 'desc')
                 ->get();
    }

    public static function getChangeFormRequestById($request_id)
    {
        return DB::table('requested_change_forms')
                 ->join('users', 'users.id', '=', 'requested_change_forms.requested_by')
                 ->join('branches', 'branches.branch_id', '=', 'requested_change_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_change_forms.outpost_id')
                 ->select(
                        'requested_change_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'name',
                       )
                 ->where('request_id', $request_id)
                 ->orderBy('request_id', 'desc')
                 ->first();
    }

    // public static function getRequestedChangeForm($bimas_br_id, $date_changed)
    // {
    //     return DB::table('requested_change_forms')
    //              ->join('users', 'users.id', '=', 'requested_change_forms.requested_by')
    //              ->join('branches', 'branches.branch_id', '=', 'requested_change_forms.branch_id')
    //              ->join('outposts', 'outposts.outpost_id', '=', 'requested_change_forms.outpost_id')
    //              ->select(
    //                     'requested_change_forms.*', 
    //                     'branch_name', 
    //                     'outpost_name',
    //                     'name',
    //                    )
    //              ->where(['bimas_br_id' => $bimas_br_id, 'date_changed' => $date_changed])
    //              ->orderBy('request_id', 'desc')
    //              ->first();
    // }

}
