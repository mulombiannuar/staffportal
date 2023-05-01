<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CRM\CustomerTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return CustomerTicket::getOutpostRandomUser(14);
        //return $loans = json_decode(file_get_contents(public_path("assets/docs/loans.json")), true);
        $pageData = [
            'page_name' => 'users',
            'title' => 'Test Application',
        ];
        //return view('admin.test', $pageData);
        return view('emails.customer_tickets_report', $pageData);
    }
}
