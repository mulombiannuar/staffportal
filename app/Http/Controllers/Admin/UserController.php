<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\BudgetTemplate;
use App\Models\DrivingLicense;
use App\Models\FuelConsumption;
use App\Models\Group;
use App\Models\InsurancePolicy;
use App\Models\Message;
use App\Models\MotorMaintenance;
use App\Models\Products\Motor;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'Manage Users',
            'users' => User::getUsers(),
        ];
        return view('user.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'Add New User',
            'counties' => DB::table('counties')->orderBy('county_name', 'asc')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('user.create', $pageData);
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
            'name' => [
                'required', 
                'string', 
                'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'mobile_no' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
                Rule::unique(Profile::class),
            ],
            'national_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Profile::class),
            ],
            'birth_date' => [
                'required', 
                'date'],
                
            'gender' => ['required'],
            'county' => ['required'],
            'religion' => ['required'],
            'sub_county' => ['required'],
        ]);

        $user = new User;
        $password =  User::generatePassword();
        $user->status = 1;
        $user->accessibility = 1;
        $user->name = $request->input('name'); 
        $user->email = $request->input('email');
        $user->password = Hash::make($password);
        $user->save();

        //assign user default bimas staff role
        $user->attachRole('bimas staff');

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->user_image = 'avatar.png';
        $profile->gender = $request->input('gender');
        $profile->county = $request->input('county');
        $profile->address = $request->input('address');
        $profile->national_id = $request->input('national_id');
        $profile->religion = $request->input('religion');
        $profile->mobile_no = $request->input('mobile_no');
        $profile->sub_county = $request->input('sub_county');
        $profile->birth_date = $request->input('birth_date');
        $profile->branch = $request->input('branch_id');
        $profile->outpost = $request->input('outpost_id');
        $profile->save();

        //Save audit trail
        $activity_type = 'User Creation';
        $description = 'Successfully created new user '.$user->name;
        User::saveAuditTrail($activity_type, $description);


        //Send account details to user
        $message = new Message();
        $systemMessage = 'Your new created account password is '.$password;
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($request->input('mobile_no')), 2);

        //$message->sendSms($mobileNo, $systemMessage);

        /// Send OTP mail
        $message->SendAccountDetails(ucwords($user->name), $user->email, $password);

        $message->message_status = 'sent'; 
        $message->message_type = 'access_token'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();
        return back()->with('success', 'New account details for '.$user->name.' created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        ///return User::getUserById($id)->phone;
        
        $pageData = [
			'page_name' => 'users',
            'title' => 'User Information',
            'user' => User::getUserById($id),
            'groups' => Group::getGroupsByOfficer('carol'),
            'counties' => DB::table('counties')->orderBy('county_name', 'asc')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('user.show', $pageData);
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
			'page_name' => 'users',
            'title' => 'Update User Information',
            'user' => User::getUserById($id),
            'counties' => DB::table('counties')->orderBy('county_name', 'asc')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('user.edit', $pageData);
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
        //return $request;
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'mobile_no' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'national_id' => [
                'required',
                'string',
                'max:255',
            ],
            'birth_date' => [
                'required', 
                'date'],
                
            'gender' => ['required'],
            'county' => ['required'],
            'religion' => ['required'],
            'sub_county' => ['required'],
        ]);

        $user = User::find($id);
        $user->name = $request->input('name'); 
        $user->email = $request->input('email');
        $user->save();

        $uProf = Profile::getProfileByUserId($id);
        $outpost_id = $request->input('outpost_id');

        if ($outpost_id !== $uProf->outpost) 
        {
            $userDevices = User::getTotalUserAssignedDevices($id);
            $gender = $uProf->gender == 'male' ? 'him' : 'her';
            
            if (count($userDevices) != 0) 
            return back()->with('warning', 'This staff '.$user->name.' cannot be transferred to the new branch you have selected because '.implode(', ', $userDevices).' are assigned to '. $gender. '. Kindly re-assign the device (s) to another staff first');
        }
        
        $profile = Profile::find($uProf->profile_id);
        $profile->gender = $request->input('gender');
        $profile->county = $request->input('county');
        $profile->address = $request->input('address');
        $profile->national_id = $request->input('national_id');
        $profile->religion = $request->input('religion');
        $profile->mobile_no = $request->input('mobile_no');
        $profile->sub_county = $request->input('sub_county');
        $profile->birth_date = $request->input('birth_date');
        $profile->branch = $request->input('branch_id');
        $profile->outpost = $request->input('outpost_id');
        $profile->save();

        //Save audit trail
        $activity_type = 'User Profile Updation';
        $description = 'Updated profile information for '.$user->name;
        User::saveAuditTrail($activity_type, $description);


        //Send account details to user
        $message = new Message();
        $systemMessage = 'Your profile details were successfully updated';
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($profile->mobile_no), 2);
        $message->message_status = 'sent'; 
        $message->message_type = 'profile_update'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();
        return back()->with('success', 'Account details for '.$user->name.' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->delete();

        //Save audit trail
        $activity_type = 'User Deletion';
        $description = 'Deleted the user '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        //$request->session()->flash('success', 'User deleted successfully');
        return back()->with('success', 'User deleted successfully');
    }

    public function activateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();

        //Save audit trail
        $activity_type = 'User Activation';
        $description = 'Activated the user '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'User activated successfully');  
    }

     public function deactivateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        
        //Save audit trail
        $activity_type = 'User Deactivation';
        $description = 'Deactivated the user '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'User deactivated successfully');  
    }

    public function password()
    {
        $pageData = [
            'user' => Auth::user(),
            'page_name' => 'password',
            'title' => 'Change Password',
        ];
        return view('user.password', $pageData);
    }

    public function passwordChange(Request $request, User $user)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' =>  ['required', 'string', new Password, 'confirmed'],
        ]);

        if(!Hash::check($request->input('current_password'), $user->password)) 
        return back()->with('danger', 'The provided password does not match your current password. Please try again');

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        //Save audit trail
        $activity_type = 'Password Change';
        $description = 'Updated account password successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Password changed successfully');
    }

    public function profile()
    {
        $pageData = [
			'page_name' => 'profile',
            'title' => 'Profile Information',
            'user' => User::getUserById(Auth::user()->id),
            'counties' => DB::table('counties')->orderBy('county_name', 'asc')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('user.profile', $pageData);
    }

    public function updateProfile(Request $request)
    {
        //return $request;
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255'],
            'mobile_no' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'national_id' => [
                'required',
                'string',
                'max:255',
            ],
            'birth_date' => [
                'required', 
                'date'],
                
            'gender' => ['required'],
            'county' => ['required'],
            'religion' => ['required'],
            'sub_county' => ['required'],
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->input('name'); 
        $user->save();

        $uProf = Profile::getProfileByUserId(Auth::user()->id);
        
        $profile = Profile::find($uProf->profile_id);
        $profile->gender = $request->input('gender');
        $profile->county = $request->input('county');
        $profile->address = $request->input('address');
        $profile->national_id = $request->input('national_id');
        $profile->religion = $request->input('religion');
        $profile->mobile_no = $request->input('mobile_no');
        $profile->sub_county = $request->input('sub_county');
        $profile->birth_date = $request->input('birth_date');
        $profile->branch = $request->input('branch_id');
        $profile->outpost = $request->input('outpost_id');
        $profile->save();

        //Save audit trail
        $activity_type = 'User Profile Updation';
        $description = 'Updated profile information details';
        User::saveAuditTrail($activity_type, $description);


        //Send account details to user
        $message = new Message();
        $systemMessage = 'Your profile details were successfully updated';
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($profile->mobile_no), 2);
        $message->message_status = 'sent'; 
        $message->message_type = 'profile_update'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();
        return back()->with('success', 'Account profile details successfully updated');
    }

    public function budgets()
    {
        $user = User::getUserById(Auth::user()->id);
        $token = null;
        if (Auth::user()->hasRole('branch manager')){
            $token = $user->branch_id;
        }

        $pageData = [
            'page_name' => 'budgets',
            'title' => 'Budget Templates',
            'templates' => BudgetTemplate::getUserTemplates(Auth::user()->id, $token),
        ];
        return view('budgets.user_budgets', $pageData);
    }

    public function assets()
    {
        $assets = User::getUserDevices(Auth::user()->id);
        $user = User::getUserById(Auth::user()->id);
        
        if (Auth::user()->hasRole('branch manager')){
            $assets = User::getBranchDevices($user->branch_id);
        }
        
        //return $devices;
        $pageData = [
            'page_name' => 'assets',
            'title' => 'User Assigned Assets',
            'devices' => $assets,
        ];
        return view('user.user_assets', $pageData);
    }

    public function motor($id)
    {
        $asset = new Motor();
        $assign = new AssignedAsset();
        $license = new DrivingLicense();
        $log = new MotorMaintenance();
        $fuel = new FuelConsumption();
        //return $log->getLogsByAssetId($id);
        $details = $asset->getMotorById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => $details->type.' Details - '.ucwords($details->chassis_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 5),
            'licenses' => $license->getLicensesByAssetId($id),
            'logs' => $log->getLogsByAssetId($id),
            'fuels' => $fuel->getConsumptionsByAssetId($id),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
            'policy' => InsurancePolicy::getInsurancePolicyByRefNumber($details->reg_no)
        ];
        return view('user.user_motors', $pageData);
    }

}