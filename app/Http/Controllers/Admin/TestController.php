<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'Test Application',
        ];
        return view('admin.test', $pageData);
    }
}