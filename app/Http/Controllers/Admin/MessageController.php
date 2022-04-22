<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $pageData = [
            'page_name' => 'messages',
            'title' => 'Messages',
            'messages'=> Message::orderBy('message_id', 'desc')->get(),
        ];
        return view('admin.messages', $pageData);
    }
}