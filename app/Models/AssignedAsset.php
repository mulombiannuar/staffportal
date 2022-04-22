<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssignedAsset extends Model
{
    use HasFactory;
    protected $table = 'assigned_assets';
    protected $primaryKey = 'assigned_id';

    public function getAssignedAssetById($assigned_id, $product_id)
    {
       $attributes = $this->getJoiningTableAttributes($product_id);
       return DB::table('assigned_assets')
                 ->join($attributes['joiningTable'], $attributes['joiningTable'].'.'.$attributes['joiningColumn'], '=', 'assigned_assets.asset_id')
                 ->join('users as current_users', 'current_users.id', '=', 'assigned_assets.current_user')
                 ->join('users as previous_users', 'previous_users.id', '=', 'assigned_assets.previous_user')
                 ->select(
                    'assigned_assets.*',
                    'current_users.name as current_user',
                    'previous_users.name as previous_user',
                   )
                ->where([
                      'assigned_id' => $assigned_id, 
                      'assigned_assets.product_id' => $product_id
                      ])
                ->first();
    }

    public function getAssetAssignedHistory($asset_id, $product_id)
    {
        $attributes = $this->getJoiningTableAttributes($product_id);
        return DB::table('assigned_assets')
                  ->join($attributes['joiningTable'], $attributes['joiningTable'].'.'.$attributes['joiningColumn'], '=', 'assigned_assets.asset_id')
                  ->join('users as current_users', 'current_users.id', '=', 'assigned_assets.current_user')
                  ->join('users as previous_users', 'previous_users.id', '=', 'assigned_assets.previous_user')
                  ->join('users as assigned_bys', 'assigned_bys.id', '=', 'assigned_assets.assigned_by')
                  ->select(
                    'assigned_assets.*',
                    'current_users.name as current_user',
                    'previous_users.name as previous_user',
                    'assigned_bys.name as assigned_name',
                   )
                  ->where([
                      'asset_id' => $asset_id, 
                      'assigned_assets.product_id' => $product_id
                      ])
                  ->orderBy('assigned_id', 'desc')
                  ->get();
    }

    public function getJoiningTableAttributes($product_id)
    {
        $attributes = [
            'joiningTable' => 'desktop',
            'joiningColumn' => 'desktop_id',
        ];
       
        if ($product_id == 1){
            $attributes = [
                'joiningTable' => 'desktops',
                'joiningColumn' => 'desktop_id',
            ];
        } 
        if ($product_id == 2){
            $attributes = [
                'joiningTable' => 'laptops',
                'joiningColumn' => 'laptop_id',
            ];
        }
        if ($product_id == 3){
            $attributes = [
                'joiningTable' => 'phones',
                'joiningColumn' => 'phone_id',
            ];
        }
        if ($product_id == 4){
            $attributes = [
                'joiningTable' => 'modems',
                'joiningColumn' => 'modem_id',
            ];
        }
        if ($product_id == 5){
            $attributes = [
                'joiningTable' => 'motors',
                'joiningColumn' => 'motor_id',
            ];
        }
        if ($product_id == 6){
            $attributes = [
                'joiningTable' => 'printers',
                'joiningColumn' => 'printer_id',
            ];
        }
        if ($product_id == 7){
            $attributes = [
                'joiningTable' => 'routers',
                'joiningColumn' => 'router_id',
            ];
        }
        if ($product_id == 8){
            $attributes = [
                'joiningTable' => 'scanners',
                'joiningColumn' => 'scanner_id',
            ];
        }
        if ($product_id == 9){
            $attributes = [
                'joiningTable' => 'switches',
                'joiningColumn' => 'switch_id',
            ];
        }
        if ($product_id == 10){
            $attributes = [
                'joiningTable' => 'power_supplies',
                'joiningColumn' => 'ups_id',
            ];
        }
        return $attributes;

    }


}