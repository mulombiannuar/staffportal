<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        $pageData = [
			'page_name' => 'groups',
            'title' => 'Groups Management',
            'groups' => Group::getGroups()
        ];
        return view('groups.index', $pageData);
    }

    public function show($id)
    {
        $group = Group::getGroupById($id);
        $pageData = [
			'page_name' => 'groups',
            'title' => $group->GroupName. ' - '. $group->GroupID,
            'group' => $group,
        ];
        return view('groups.show', $pageData);
    }

    public function officers()
    {
        $pageData = [
			'page_name' => 'groups',
            'title' => 'Manage Officers',
        ];
        return view('groups.officers', $pageData);
    }

    public function officerGroups($id)
    {
        $pageData = [
			'page_name' => 'groups',
            'title' => 'Officer Groups',
            'groups' => Group::getGroupsByOfficer(strtoupper($id)),
        ];
        return view('groups.officer_groups', $pageData);
    }

    /// For logged in user
    public function userGroups()
    {
        $pageData = [
			'page_name' => 'groups',
            'title' => 'Officer Groups',
            'groups' => Group::getGroupsByOfficer('CAROL'),
        ];
        return view('user.user_groups', $pageData);
    }


}