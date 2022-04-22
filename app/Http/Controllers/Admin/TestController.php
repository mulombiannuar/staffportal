<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return  DB::table('tbl_bookings')
        ->join('tbl_motorbikes_repairs', 'tbl_motorbikes_repairs.booking_id', '=', 'tbl_bookings.booking_id')
        ->join('tbl_motorbikes', 'tbl_motorbikes.motorbike_id', '=', 'tbl_bookings.booked_motorbike_id')
        ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_bookings.booked_user_id')
        ->select(
             'tbl_bookings.*', 
             'tbl_users.user_email',
             'tbl_motorbikes.motorbike_registration', 
             'tbl_motorbikes_repairs.service_date',
             'tbl_motorbikes_repairs.action_done as service_done',
             'tbl_motorbikes_repairs.action_by',
             'tbl_motorbikes_repairs.repair_cost',
             'tbl_motorbikes_repairs.repair_reason',
             )
        ->get();
    }
}