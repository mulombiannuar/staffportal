<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\InsuranceController;
use App\Models\InsurancePolicy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePoliciesData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $policies = DB::table('tbl_insurance_policies')
                      ->leftJoin('tbl_users', 'tbl_users.user_id', '=', 'tbl_insurance_policies.client_officer')
                      ->get();

        for ($s=0; $s <count($policies) ; $s++) 
        { 
            $user = User::where('email', $policies[$s]->user_email)->first();
            $userData = User::getUserById(is_null($user)? 164 : $user->id);
            $insurance = new InsurancePolicy();
            $insurance->outpost = is_null($userData)? 1 : $userData->outpost;
            $insurance->product = 1;
            $insurance->company = $policies[$s]->company_id;
            $insurance->officer = is_null($userData)? 164 : $userData->id;
            $insurance->client_name = $policies[$s]->client_name;
            $insurance->client_phone = $policies[$s]->client_phone;
            $insurance->client_id = $policies[$s]->client_id;
            $insurance->client_kra = $policies[$s]->client_kra;
            $insurance->sum_issued = $policies[$s]->sum_issued;
            $insurance->premium = $policies[$s]->premium;
            $insurance->reference = $policies[$s]->ref_number;
            $insurance->date_issued = $policies[$s]->date_issued;
            $insurance->date_expired = $policies[$s]->date_expired;
            $insurance->cheque_no = $policies[$s]->cheque_no;
            $insurance->policy_no = InsuranceController::generatePolicyNumber(1);
            $insurance->created_by = 164;
            $insurance->status = 1;
            $insurance->save();
        }
        
    }
}