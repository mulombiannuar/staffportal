<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CRM\CustomerTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shivella\Bitly\Facade\Bitly;

class TestController extends Controller
{
    public function index()
    {
        //return app('bitly')->getUrl('https://www.google.com/');
        //return Bitly::getUrl('https://www.google.com/');
        return
            //return $loans = json_decode(file_get_contents(public_path("assets/docs/loans.json")), true);
            $pageData = [
                'page_name' => 'users',
                'title' => 'Test Application',
            ];
        //return view('admin.test', $pageData);
        return view('emails.customer_tickets_report', $pageData);
    }
}
