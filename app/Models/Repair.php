<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Repair extends Model
{
    use HasFactory;
    protected $table = 'repairs';
    protected $primaryKey = 'repair_id';

    public function getAssetRepairs()
    {
        $log = new MaintenanceLog();
        $repairs =  DB::table('repairs')
                    ->join('users as current_users', 'current_users.id', '=', 'repairs.current_user')
                    ->join('users as actions_bys', 'actions_bys.id', '=', 'repairs.action_by')
                    ->join('asset_types', 'asset_types.asset_id', '=', 'repairs.product_id')
                    ->select(
                        'repairs.*',
                        'asset_types.asset_name',
                        'current_users.name as current_user',
                        'current_users.id as current_user_id',
                        'actions_bys.name as action_name',
                    )
                    ->orderBy('repair_id', 'desc')
                    ->get();
                    
        for ($s=0; $s <count($repairs) ; $s++) 
        { 
            $repairs[$s]->assetDetails = $log->getAssetDetails($repairs[$s]->product_id, $repairs[$s]->asset_id);
            $repairs[$s]->branch_name = $log->getAssetBranch($repairs[$s]->current_user_id)->branch_name;
        }
        return $repairs;
    }

    public function getAssetRepairHistory($asset_id, $product_id)
    {
        $assigned = new AssignedAsset();
        $attributes =  $assigned->getJoiningTableAttributes($product_id);
        return DB::table('repairs')
                  ->join($attributes['joiningTable'], $attributes['joiningTable'].'.'.$attributes['joiningColumn'], '=', 'repairs.asset_id')
                  ->join('users as current_users', 'current_users.id', '=', 'repairs.current_user')
                  ->join('users as actions_bys', 'actions_bys.id', '=', 'repairs.action_by')
                  ->select(
                    'repairs.*',
                    'current_users.name as current_user',
                    'actions_bys.name as action_name',
                   )
                  ->where([
                      'asset_id' => $asset_id, 
                      'repairs.product_id' => $product_id
                      ])
                  ->orderBy('repair_id', 'desc')
                  ->get();
    }


}