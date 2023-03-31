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
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait, SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'accessibility'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function desktop()
    {
        return $this->hasOne(Desktop::class, 'assigned_to', 'id');
    }

    public function laptop()
    {
        return $this->hasOne(Laptop::class, 'assigned_to', 'id');
    }

    public function phone()
    {
        return $this->hasOne(Phone::class, 'assigned_to', 'id');
    }

    public function modem()
    {
        return $this->hasOne(Modem::class, 'assigned_to', 'id');
    }

    public function motor()
    {
        return $this->hasOne(Motor::class, 'assigned_to', 'id');
    }

    public function printer()
    {
        return $this->hasOne(Printer::class, 'assigned_to', 'id');
    }

    public function router()
    {
        return $this->hasOne(Router::class, 'assigned_to', 'id');
    }

    public function scanner()
    {
        return $this->hasOne(Scanner::class, 'assigned_to', 'id');
    }

    public function swittch()
    {
        return $this->hasOne(Swittch::class, 'assigned_to', 'id');
    }

    public function ups()
    {
        return $this->hasOne(PowerSupply::class, 'assigned_to', 'id');
    }

    public static function getUserByMobileNumber($mobile_no)
    {
         return DB::table('users')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->select('users.email','users.name','profiles.*')
                  ->where('mobile_no', $mobile_no)
                  ->where('deleted_at', null)
                  ->where('status', 1)
                  ->first();
    }

    public static function getUsers()
    {
       return  User::where('accessibility', 1)
                    // ->where('status', 1)
                    ->where('deleted_at', null)
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id' )
                    ->leftJoin('outposts', 'outposts.outpost_id', '=', 'profiles.outpost' )
                    ->orderBy('id', 'desc')
                    ->get();
    }

    public static function getBranchUsers($id)
    {
       return  User::where(['accessibility' => 1, 'status' => 1, 'deleted_at'=> null, 'branch' => $id])
                    ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost' )
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->select(
                        'users.id', 
                        'users.email', 
                        'users.name',
                        'users.name',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'profiles.mobile_no',
                        )
                    ->orderBy('id', 'desc')
                    ->get();
    }

    public static function getOutpostUsers($id)
    {
       return  User::where(['accessibility' => 1,'status' => 1, 'deleted_at'=> null, 'outpost' => $id])
                    ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost' )
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->select(
                        'users.id', 
                        'users.email', 
                        'users.name',
                        'users.name',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'profiles.mobile_no',
                        )
                    ->orderBy('id', 'desc')
                    ->get();
    }

    public static function getUserById($id)
    {
       return  User::where('id', $id)
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                    ->join('sub_counties', 'sub_counties.sub_id', '=', 'sub_county')
                    ->join('counties', 'counties.county_id', '=', 'profiles.county')
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->first();
    }

    public static function getUsersById(array $ids)
    {
       return  User::whereIn('id', $ids)
                    ->where('status', 1)
                    ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                    ->join('sub_counties', 'sub_counties.sub_id', '=', 'sub_county')
                    ->join('counties', 'counties.county_id', '=', 'profiles.county')
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->select('name', 'email', 'user_id', 'mobile_no', 'outpost', 'branch')
                    ->get();
    }

    public static function getUserIpAddress()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function saveAuditTrail($activity_type, $description)
    {
        //Save audit trail
        return  DB::table('audit_trails')->insert([
            'user_id' => Auth::user()->id,
            'description' => $description,
            'activity_type' => $activity_type,
            'ip_address' => User::getUserIpAddress(),
            'created_at' => Carbon::now(),
            'date' => Carbon::now()
        ]);

    }

    public static function generatePassword()
    {
        //$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789@#$%&';
        $length = 10;
        $str = '';
        $max = strlen($chars) - 1;
      
        for ($i=0; $i < $length; $i++)
          $str .= $chars[random_int(0, $max)];
      
        return $str;
    }

    
    public static function getUserDevices($user_id)
    {
        return 
        [
            'phones' => Phone::getUserPhones($user_id),
            'laptops' => Laptop::getUserLaptops($user_id),
            'motors' => Motor::getUserMotors($user_id),
            'desktops' => Desktop::getUserDesktops($user_id),
        ];
    }

    public static function getTotalUserAssignedDevices($user_id)
    {
        $devices = [];
        $phones = Phone::getUserPhones($user_id)->count();
        $laptops = Laptop::getUserLaptops($user_id)->count();
        $motors = Motor::getUserMotors($user_id)->count();
        $desktops = Desktop::getUserDesktops($user_id)->count();
        $printers = Printer::where('assigned_to', $user_id)->get()->count();
        $routers = Router::where('assigned_to', $user_id)->get()->count();
        $scanners = Scanner::where('assigned_to', $user_id)->get()->count();
        $switches = Swittch::where('assigned_to', $user_id)->get()->count();
        $ups = PowerSupply::where('assigned_to', $user_id)->get()->count();

        if ($phones > 0) {
            array_push($devices, $phones.' phone');
        }

        if ($laptops > 0) {
            array_push($devices, $laptops.' laptop');
        }

        if ($motors > 0) {
            array_push($devices, $motors.' motor');
        }

        if ($desktops > 0) {
            array_push($devices, $desktops.' desktop');
        }

        if ($printers > 0) {
            array_push($devices, $printers.' printer');
        }

        if ($routers > 0) {
            array_push($devices, $routers.' router');
        }

        if ($scanners > 0) {
            array_push($devices, $scanners.' scanner');
        }

        if ($switches > 0) {
            array_push($devices, $switches.' switch');
        }

        if ($ups > 0) {
            array_push($devices, $ups.' power supply');
        }
        
        return $devices;
    }

    public static function getBranchDevices($branch_id)
    {
        $phone = new Phone();
        $laptop = new Laptop();
        $motor = new Motor();
        $desktop = new Desktop();
        return  
        [
            'phones' => $phone->getBranchPhones($branch_id),
            'laptops' => $laptop->getBranchLaptops($branch_id),
            'motors' => $motor->getBranchMotors($branch_id),
            'desktops' => $desktop->getBranchDesktops($branch_id),
        ];
    }

    public static function hasSeniorManagerRole($user_id)
    {
        $user = User::find($user_id);
        if ($user->hasRole('finance manager') 
        || $user->hasRole('ict manager')
        || $user->hasRole('audit manager')
        || $user->hasRole('legal manager')
        || $user->hasRole('credits manager')
        || $user->hasRole('marketing manager')
        || $user->hasRole('operations manager')
        || $user->hasRole('human resource manager')
        ) return true;
        
        return false;
    }
}