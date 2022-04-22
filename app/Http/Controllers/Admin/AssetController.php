<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\DrivingLicense;
use App\Models\FuelConsumption;
use App\Models\MaintenanceLog;
use App\Models\MotorMaintenance;
use App\Models\Products\Laptop;
use App\Models\Products\Desktop;
use App\Models\Products\Modem;
use App\Models\Products\Motor;
use App\Models\Products\Phone;
use App\Models\Products\PowerSupply;
use App\Models\Products\Printer;
use App\Models\Products\Router;
use App\Models\Products\Scanner;
use App\Models\Products\Swittch;
use App\Models\Profile;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Assets Management Dashboard',
            'stats' => [
                'repairs' => count(Repair::all()),
                'logs' => count(MaintenanceLog::all()),
                'types' => count(DB::table('asset_types')->get()),
                'licenses' => count(DrivingLicense::get()),
                'motors' => count(Motor::get()),
                'motors_logs' => count(MotorMaintenance::get()),
                'fuels' => count(FuelConsumption::get()),
                'printers' => count(Printer::get()),
                'routers' => count(Router::get()),
            ]
        ];
        return view('assets.index', $pageData);
    }

    public function show($asset_name)
    {
        if (strtolower($asset_name) == 'desktops') {
            $desktop = new Desktop();
            $assets = $desktop->getDesktops();
            $view = 'assets.desktop.index';
        }
        elseif (strtolower($asset_name) == 'laptops') {
            $laptop = new Laptop();
            $assets = $laptop->getLaptops();
            $view = 'assets.laptop.index';
        }
        elseif (strtolower($asset_name) == 'phones') {
            $phone = new Phone();
            $assets = $phone->getPhones();
            $view = 'assets.phone.index';
        }
        elseif (strtolower($asset_name) == 'modems') {
            $modem = new Modem();
            $assets = $modem->getModems();
            $view = 'assets.modem.index';
        }
        elseif (strtolower($asset_name) == 'motors') {
            $motor = new Motor();
            $assets = $motor->getMotors();
            $view = 'assets.motor.index';
        }
        elseif (strtolower($asset_name) == 'printers') {
            $printers = new Printer();
            $assets = $printers->getPrinters();
            $view = 'assets.printer.index';
        }
        elseif (strtolower($asset_name) == 'scanners') {
            $scanner = new Scanner();
            $assets = $scanner->getScanners();
            $view = 'assets.scanner.index';
        }
        elseif (strtolower($asset_name) == 'routers') {
            $routers = new Router();
            $assets = $routers->getRouters();
            $view = 'assets.router.index';
        }
        elseif (strtolower($asset_name) == 'switches') {
            $switch = new Swittch();
            $assets = $switch->getSwitches();
            $view = 'assets.switch.index';
        }
        elseif (strtolower($asset_name) == 'ups') {
            $ups = new PowerSupply();
            $assets = $ups->getPowerSupplies();
            $view = 'assets.ups.index';
        }
        else{
            $desktop = new Desktop();
            $assets = $desktop->getDesktops();
            $view = 'assets.desktop.index';
        }

        $pageData = [
            'assets' => $assets,
			'page_name' => 'assets',
            'title' => ucwords($asset_name),
            'branches' => Admin::getBranches(),
        ];
        return view($view, $pageData);
    }

    public function categories()
    {
        //return Admin::getAssetsCategories();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Asset Categories',
            'categories' => Admin::getAssetsCategories()
        ];
        return view('assets.categories', $pageData);
    }

    public function assignAsset(Request $request)
    {
        $request->validate([
            'current_user' => [
                'required', 
                'integer', 
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'asset_id' => [
                'required',
                'integer',
            ],
            'message' => [
                'required',
                'string',
            ],

        ]);

        $new_user = $request->input('user_id');
        $current_user = $request->input('current_user');
        $product_id = $request->input('product_id');
        $asset_id = $request->input('asset_id');

        if ($new_user == $current_user)
        return back()->with('danger', 'The user is already assigned with the same asset');
        
        if($product_id == 1){
            $desktop = Desktop::find($asset_id);
            $desktop->assigned_to = $new_user;
            $desktop->save();
        }
        elseif($product_id == 2){
            $laptop = Laptop::find($asset_id);
            $laptop->assigned_to = $new_user;
            $laptop->save();
        }
        elseif($product_id == 3){
            $phone = Phone::find($asset_id);
            $phone->assigned_to = $new_user;
            $phone->save();
        }
        elseif($product_id == 4){
            $modem = Modem::find($asset_id);
            $modem->assigned_to = $new_user;
            $modem->save();
        }
        elseif($product_id == 5){
            $motor = Motor::find($asset_id);
            $motor->assigned_to = $new_user;
            $motor->save();
        }
        elseif($product_id == 6){
            $printer = Printer::find($asset_id);
            $printer->assigned_to = $new_user;
            $printer->save();
        }
        elseif($product_id == 7){
            $router = Router::find($asset_id);
            $router->assigned_to = $new_user;
            $router->save();
        }
        elseif($product_id == 8){
            $scanner = Scanner::find($asset_id);
            $scanner->assigned_to = $new_user;
            $scanner->save();
        }
        elseif($product_id == 9){
            $switch = Swittch::find($asset_id);
            $switch->assigned_to = $new_user;
            $switch->save();
        }
        elseif($product_id == 10){
            $ups = PowerSupply::find($asset_id);
            $ups->assigned_to = $new_user;
            $ups->save();
        }
        else{
            $desktop = Desktop::find($asset_id);
            $desktop->assigned_to = $new_user;
            $desktop->save();
        }
        
        $asset = new AssignedAsset();
        $asset->previous_user = $current_user;
        $asset->current_user = $new_user;
        $asset->asset_id = $asset_id;
        $asset->product_id = $product_id;
        $asset->date_assigned = $request->input('date_assigned');
        $asset->message = $request->input('message');
        $asset->assigned_by = Auth::user()->id;
        $asset->save();

        //Save audit trail
        $activity_type = 'Asset Users Reassigning';
        $description = 'Assigned asset id '.$asset->asset_id.' of category id '.$asset->product_id.' to '.User::find($asset->current_user)->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset assigned successfully to another user');
    }

    public function updateAssignment(Request $request, $id)
    {
        $request->validate([
            'message' => [
                'required',
                'string',
            ],
            'date_assigned' => [
                'required',
                'string',
            ],

        ]);

        $asset = AssignedAsset::find($id);
        $asset->date_assigned = $request->input('date_assigned');
        $asset->message = $request->input('message');
        $asset->assigned_by = Auth::user()->id;
        $asset->save();

        //Save audit trail
        $activity_type = 'Asset Reassigning Updation';
        $description = 'Updated asset assignment id '.$asset->assigned_id.' of category id '.$asset->product_id.' for '.User::find($asset->current_user)->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset assignment successfully updated');
    }

    public function deleteAssignment($id)
    {
        AssignedAsset::find($id)->delete();

        //Save audit trail
        $activity_type = 'Asset Reassignment Deletion';
        $description = 'Successfully deleted asset reassignment ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset assignment successfully deleted');
    }

    public function repairsData()
    {
        $repair = new Repair();
        //return $repair->getAssetRepairs();
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Assets Repairs',
			'repairs' => $repair->getAssetRepairs(),
        ];
        return view('assets.repairs', $pageData);
    }

    public function saveRepairData(Request $request)
    {
        $request->validate([
            'current_user' => [
                'required',
                'integer',
            ],
            'asset_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'asset_issue' => [
                'required',
                'string',
            ],
            'action_done' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'numeric',
            ],
            'date_done' => [
                'required',
                'string',
            ],

        ]);

        $repair = new Repair();
        $repair->product_id = $request->input('product_id');
        $repair->asset_id = $request->input('asset_id');
        $repair->asset_issue = $request->input('asset_issue');
        $repair->action_done = $request->input('action_done');
        $repair->current_user = $request->input('current_user');
        $repair->cost = $request->input('cost');
        $repair->date_done = $request->input('date_done');
        $repair->action_by = Auth::user()->id;
        $repair->save();

        //Save audit trail
        $activity_type = 'Asset Repair Lodging';
        $description = 'Created new repair data for the asset id '.$repair->asset_id .' dated '.$repair->date_done;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.repairs.index'))->with('success', 'Asset repair data for the selected item successfully saved');
    }

    public function updateRepairData(Request $request, $id)
    {
        $request->validate([
            'asset_issue' => [
                'required',
                'string',
            ],
            'action_done' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'numeric',
            ],
            'date_done' => [
                'required',
                'string',
            ],

        ]);

        $repair = Repair::find($id);
        $repair->asset_issue = $request->input('asset_issue');
        $repair->action_done = $request->input('action_done');
        $repair->cost = $request->input('cost');
        $repair->date_done = $request->input('date_done');
        $repair->action_by = Auth::user()->id;
        $repair->save();

        //Save audit trail
        $activity_type = 'Asset Repair Updation';
        $description = 'Updated repair data for the asset id '.$repair->asset_id .' dated '.$repair->date_done;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset repair data for the selected item successfully updated');
    }

    public function deleteRepairData($id)
    {
        Repair::find($id)->delete();

        //Save audit trail
        $activity_type = 'Repair Data Deletion';
        $description = 'Successfully deleted asset repair data ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset repair data successfully deleted');
    }

    public function maintenanceLogs()
    {
        $log = new MaintenanceLog();
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Assets Maintenance',
			'logs' => $log->getMaintenanceLogs(),
        ];
        return view('assets.logs.index', $pageData);
    }
    
    public function addMaintenanceLogData($product_id, $asset_id)
    {
        if ($product_id == 1) {
            $view = 'desktop_add';
            $asset = Desktop::find($asset_id);
        }
        elseif($product_id == 2){
            $view = 'laptop_add';
            $asset = Laptop::find($asset_id);
        }
        else{
            $view = 'desktop_add';
            $asset = Desktop::find($asset_id);
        }
        
        $pageData = [
			'asset' => $asset,
            'page_name' => 'assets',
            'title' => 'Fill Maintenance Log',
        ];
        return view('assets.logs.'.$view, $pageData);
    }

    public function editMaintenanceLogData($id)
    {
        $view = 'desktop_edit';
        $log = MaintenanceLog::find($id);;
        if ($log->product_id == 1) {
            $view = 'desktop_edit';
            $log = MaintenanceLog::find($id);
        }
        
        $pageData = [
			'log' => $log,
            'page_name' => 'assets',
            'title' => 'Edit Maintenance Log',
        ];
        return view('assets.logs.'.$view, $pageData);
    }

    public function showMaintenanceLogData($id, $product_id)
    {
        $logModel = new MaintenanceLog();
        $view = 'desktop_show';
        $log = MaintenanceLog::getAssetLogById($id, $product_id);;
        if ($product_id == 1) {
            $view = 'desktop_show';
            $log = MaintenanceLog::getAssetLogById($id, $product_id);
        }

        $pageData = [
			'log' => $log,
            'page_name' => 'assets',
            'title' => 'Asset Maintenance Log',
            'branch' => $logModel->getAssetBranch($log->assigned_to)
        ];
        return view('assets.logs.'.$view, $pageData);
    }

    public function saveMaintenanceLogData(Request $request)
    {
       // return $request;
        $request->validate([
            'current_user' => [
                'required',
                'integer',
            ],
            'asset_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'date_done' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'string',
            ],
            'hdw_log_status' => [
                'required',
                'string',
            ],
            'hdw_log_comment' => [
                'required',
                'string',
            ],
            'hdd_cleanup_status' => [
                'required',
                'string',
            ],
            'hdd_cleanup_comment' => [
                'required',
                'string',
            ],
            'hdd_capacity_status' => [
                'required',
                'string',
            ],
            'hdd_capacity_comment' => [
                'required',
                'string',
            ],
            'hdw_tools_status' => [
                'required',
                'string',
            ],
            'hdw_tools_comment' => [
                'required',
                'string',
            ],
            'windows_update_status' => [
                'required',
                'string',
            ],
            'windows_update_comment' => [
                'required',
                'string',
            ],
            'browser_status' => [
                'required',
                'string',
            ],
            'browser_comment' => [
                'required',
                'string',
            ],
            'sftw_status' => [
                'required',
                'string',
            ],
            'sftw_comment' => [
                'required',
                'string',
            ],
            'antivirus_status' => [
                'required',
                'string',
            ],
            'antivirus_comment' => [
                'required',
                'string',
            ],
            'antivirus_log' => [
                'required',
                'string',
            ],
            'antivirus_log_comment' => [
                'required',
                'string',
            ],
            'security_log' => [
                'required',
                'string',
            ],
            'security_log_comment' => [
                'required',
                'string',
            ],
            'backup_status' => [
                'required',
                'string',
            ],
            'backup_comment' => [
                'required',
                'string',
            ],
        ]);

        $log = new MaintenanceLog();
        $log->product_id = $request->input('product_id');
        $log->asset_id = $request->input('asset_id');
        $log->current_user = $request->input('current_user');
        $log->cost = $request->input('cost');
        $log->date_done = $request->input('date_done');
        $log->action_by = Auth::user()->id;
        $log->hdw_log_status = $request->input('hdw_log_status');
        $log->hdw_log_comment = $request->input('hdw_log_comment');
        $log->hdd_cleanup_status = $request->input('hdd_cleanup_status');
        $log->hdd_cleanup_comment = $request->input('hdd_cleanup_comment');
        $log->hdd_capacity_status = $request->input('hdd_capacity_status');
        $log->hdd_capacity_comment = $request->input('hdd_capacity_comment');
        $log->hdw_tools_status = $request->input('hdw_tools_status');
        $log->hdw_tools_comment = $request->input('hdw_tools_comment');
        $log->windows_update_status = $request->input('windows_update_status');
        $log->windows_update_comment = $request->input('windows_update_comment');
        $log->browser_status = $request->input('browser_status');
        $log->browser_comment = $request->input('browser_comment');
        $log->sftw_status = $request->input('sftw_status');
        $log->sftw_comment = $request->input('sftw_comment');
        $log->antivirus_status = $request->input('antivirus_status');
        $log->antivirus_comment = $request->input('antivirus_comment');
        $log->antivirus_log = $request->input('antivirus_log');
        $log->antivirus_log_comment = $request->input('antivirus_log_comment');
        $log->security_log = $request->input('security_log');
        $log->security_log_comment = $request->input('security_log_comment');
        $log->backup_status = $request->input('backup_status');
        $log->backup_comment = $request->input('backup_comment');
        $log->save();

        //Save audit trail
        $activity_type = 'Maintenance Log Creation';
        $description = 'Created new Maintenance log data for the asset id '.$log->asset_id .' dated '.$log->date_done;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.logs.index'))->with('success', 'Maintenance log data successfully saved');
    }

    public function updateMaintenanceLogData(Request $request, $id)
    {
        $request->validate([
            'date_done' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'string',
            ],
            'hdw_log_status' => [
                'required',
                'string',
            ],
            'hdw_log_comment' => [
                'required',
                'string',
            ],
            'hdd_cleanup_status' => [
                'required',
                'string',
            ],
            'hdd_cleanup_comment' => [
                'required',
                'string',
            ],
            'hdd_capacity_status' => [
                'required',
                'string',
            ],
            'hdd_capacity_comment' => [
                'required',
                'string',
            ],
            'hdw_tools_status' => [
                'required',
                'string',
            ],
            'hdw_tools_comment' => [
                'required',
                'string',
            ],
            'windows_update_status' => [
                'required',
                'string',
            ],
            'windows_update_comment' => [
                'required',
                'string',
            ],
            'browser_status' => [
                'required',
                'string',
            ],
            'browser_comment' => [
                'required',
                'string',
            ],
            'sftw_status' => [
                'required',
                'string',
            ],
            'sftw_comment' => [
                'required',
                'string',
            ],
            'antivirus_status' => [
                'required',
                'string',
            ],
            'antivirus_comment' => [
                'required',
                'string',
            ],
            'antivirus_log' => [
                'required',
                'string',
            ],
            'antivirus_log_comment' => [
                'required',
                'string',
            ],
            'security_log' => [
                'required',
                'string',
            ],
            'security_log_comment' => [
                'required',
                'string',
            ],
            'backup_status' => [
                'required',
                'string',
            ],
            'backup_comment' => [
                'required',
                'string',
            ],
        ]);

        $log = MaintenanceLog::find($id);
        $log->cost = $request->input('cost');
        $log->date_done = $request->input('date_done');
        $log->action_by = Auth::user()->id;
        $log->hdw_log_status = $request->input('hdw_log_status');
        $log->hdw_log_comment = $request->input('hdw_log_comment');
        $log->hdd_cleanup_status = $request->input('hdd_cleanup_status');
        $log->hdd_cleanup_comment = $request->input('hdd_cleanup_comment');
        $log->hdd_capacity_status = $request->input('hdd_capacity_status');
        $log->hdd_capacity_comment = $request->input('hdd_capacity_comment');
        $log->hdw_tools_status = $request->input('hdw_tools_status');
        $log->hdw_tools_comment = $request->input('hdw_tools_comment');
        $log->windows_update_status = $request->input('windows_update_status');
        $log->windows_update_comment = $request->input('windows_update_comment');
        $log->browser_status = $request->input('browser_status');
        $log->browser_comment = $request->input('browser_comment');
        $log->sftw_status = $request->input('sftw_status');
        $log->sftw_comment = $request->input('sftw_comment');
        $log->antivirus_status = $request->input('antivirus_status');
        $log->antivirus_comment = $request->input('antivirus_comment');
        $log->antivirus_log = $request->input('antivirus_log');
        $log->antivirus_log_comment = $request->input('antivirus_log_comment');
        $log->security_log = $request->input('security_log');
        $log->security_log_comment = $request->input('security_log_comment');
        $log->backup_status = $request->input('backup_status');
        $log->backup_comment = $request->input('backup_comment');
        $log->save();

        //Save audit trail
        $activity_type = 'Maintenance Log Updation';
        $description = 'Updated Maintenance log data for the asset id '.$log->asset_id .' dated '.$log->date_done;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Maintenance log data for the selected asset successfully updated');
    }

    public function deleteMaintenanceLogData($id)
    {
        MaintenanceLog::find($id)->delete();

        //Save audit trail
        $activity_type = 'MaintenanceLog Data Deletion';
        $description = 'Successfully deleted asset Maintenance Log Data';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset Maintenance Log Data successfully deleted');
    }

    public function commentMaintenanceLogData(Request $request, $id)
    {
        $request->validate([
            'comment' => [
                'required',
                'string',
            ],
        ]);

        $type = $request->input('type');
        $comment = $request->input('comment');
        $log = MaintenanceLog::find($id);
        $type == 'officer' ? $log->supervisor_comment = $comment 
                           : $log->manager_comment = $comment ;
        $log->save();

        //Save audit trail
        $activity_type = 'ICT Log Commenting';
        $description = 'Commented on Maintenance log data for the asset id '.$log->asset_id .' dated '.$log->date_done;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully commented on maintenance log sheet');
    }

}