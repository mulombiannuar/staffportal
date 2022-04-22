<?php

namespace App\Models;

use App\Models\Products\Desktop;
use App\Models\Products\Laptop;
use App\Models\Products\Modem;
use App\Models\Products\Motor;
use App\Models\Products\Phone;
use App\Models\Products\PowerSupply;
use App\Models\Products\Printer;
use App\Models\Products\Router;
use App\Models\Products\Scanner;
use App\Models\Products\Swittch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaintenanceLog extends Model
{
    use HasFactory;
    protected $table = 'maintenance_logs';
    protected $primaryKey = 'log_id';

    public function getMaintenanceLogs()
    {
        $logs = DB::table('maintenance_logs')
                  ->join('users as current_users', 'current_users.id', '=', 'maintenance_logs.current_user')
                  ->join('users as actions_bys', 'actions_bys.id', '=', 'maintenance_logs.action_by')
                  ->join('asset_types', 'asset_types.asset_id', '=', 'maintenance_logs.product_id')
                  ->select(
                    'maintenance_logs.*',
                    'asset_types.asset_name',
                    'current_users.name as current_user',
                    'current_users.id as current_user_id',
                    'actions_bys.name as action_name',
                   )
                  ->orderBy('date_done', 'desc')
                  ->get();

        for ($s=0; $s <count($logs) ; $s++) 
        { 
            $logs[$s]->assetDetails = $this->getAssetDetails($logs[$s]->product_id, $logs[$s]->asset_id);
            $logs[$s]->branch_name = $this->getAssetBranch($logs[$s]->current_user_id)->branch_name;
        }
        return $logs;
    }

    public function getAssetLogHistory($asset_id, $product_id)
    {
        $assigned = new AssignedAsset();
        $attributes =  $assigned->getJoiningTableAttributes($product_id);
        return DB::table('maintenance_logs')
                  ->join($attributes['joiningTable'], $attributes['joiningTable'].'.'.$attributes['joiningColumn'], '=', 'maintenance_logs.asset_id')
                  ->join('users as current_users', 'current_users.id', '=', 'maintenance_logs.current_user')
                  ->join('users as actions_bys', 'actions_bys.id', '=', 'maintenance_logs.action_by')
                  ->select(
                    'maintenance_logs.*',
                    $attributes['joiningTable'].'.*',
                    'current_users.name as current_user',
                    'actions_bys.name as action_name',
                   )
                  ->where([
                      'asset_id' => $asset_id, 
                      'maintenance_logs.product_id' => $product_id
                      ])
                  ->orderBy('log_id', 'desc')
                  ->get();
    }

    public static function getAssetLogById($log_id, $product_id)
    {
        $assigned = new AssignedAsset();
        $attributes =  $assigned->getJoiningTableAttributes($product_id);
        return DB::table('maintenance_logs')
                  ->join($attributes['joiningTable'], $attributes['joiningTable'].'.'.$attributes['joiningColumn'], '=', 'maintenance_logs.asset_id')
                  ->join('users as current_users', 'current_users.id', '=', 'maintenance_logs.current_user')
                  ->join('users as actions_bys', 'actions_bys.id', '=', 'maintenance_logs.action_by')
                  ->select(
                    'maintenance_logs.*',
                    $attributes['joiningTable'].'.*',
                    'current_users.name as current_user',
                    'actions_bys.name as action_name',
                    'actions_bys.email as action_email',
                   )
                  ->where('log_id', $log_id)
                  ->first();
    }

    public function getAssetDetails($product_id, $asset_id)
    {
        switch ($product_id) 
        {
            case 1:
                $desktop = new Desktop();
                $asset = $desktop->getDesktopById($asset_id);
                break;

            case 2:
                $laptop = new Laptop();
                $asset = $laptop->getLaptopById($asset_id);
                break;

            case 3:
                $phone = new Phone();
                $asset = $phone->getPhoneById($asset_id);
                break;

            case 4:
                $modem = new Modem();
                $asset = $modem->getModemById($asset_id);
                break;

            case 5:
                $motor = new Motor();
                $asset = $motor->getMotorById($asset_id);
                break;

            case 6:
                $printer = new Printer();
                $asset = $printer->getPrinterById($asset_id);
                break;

            case 7:
                $router = new Router();
                $asset = $router->getRouterById($asset_id);
                break;

            case 8:
                $scanner = new Scanner();
                $asset = $scanner->getScannerById($asset_id);
                break;

            case 9:
                $switch = new Swittch();
                $asset = $switch->getSwitchById($asset_id);
                break;

            case 10:
                $ups = new PowerSupply();
                $asset = $ups->getPowerSupplyById($asset_id);
                break;
            
            default:
                $desktop = new Desktop();
                $asset = $desktop->getDesktopById($asset_id);
            break;
        }
        return $asset;
    }

    public function getAssetBranch($user_id)
    {
        return Admin::getBranchById(Profile::where('user_id', $user_id)->pluck('branch'));
    }
    

}