<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CreateUsersList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('tbl_users')->get();
        for ($s=0; $s <count($users) ; $s++) 
        { 
           $user = User::create([
                'name' => $users[$s]->user_name,
                'email' => $users[$s]->user_email,
                'password' => Hash::make('@Bimas2022?'),
                'accessibility' => 1,
                'status' => 1,
            ]);
            $user->attachRole('bimas staff');

            Profile::create([
                'user_id' => $user->id,
                'mobile_no' => $users[$s]->user_phone,
                'branch' => $users[$s]->user_branch_id,
                'outpost' => $users[$s]->user_outpost_id,
                'birth_date' => $faker->dateTimeBetween('-20 month', '+20 month'),
                'user_image' => 'avatar.png',
                'address' => 'P.O Box 2299, Embu',
                'national_id' => rand(20554548,36987863),
                'religion' => 'Christian',
                'gender' => 'male',
                'county' => 21,
                'sub_county' => 131,
            ]);
        }
    }
}