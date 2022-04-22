<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMeeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GroupMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userGroupMeetings()
    {
        $meeting = new GroupMeeting();
        $pageData = [
			'page_name' => 'groups',
            'title' => 'Officer Groups Meetings',
            'groups' => Group::getGroupsByOfficer('CAROL'),
            'meetings' => $meeting->getMeetingsByUserId(Auth::user()->id)
        ];
        return view('user.user_group_meetings', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_code' => [
                'required', 
                'string',
                Rule::unique(GroupMeeting::class), 
            ],
            'day' => [
                'required',
                'string',
            ],
            'frequency' => [
                'required',
                'string',
            ],
            'starting_time' => [
                'required',
                'string',
            ],
            'ending_time' => [
                'required',
                'string',
            ],
            'place' => [
                'required',
                'string',
            ],
           
        ]);

        $groupString = $request->input('group_code');
        $groupData = explode('%', $groupString);
        $group_code = $groupData[0];
        $group_name = $groupData[1];
        $officer = $groupData[2];
        $userId = $request->input('user_id');

        $meetingExists = GroupMeeting::where('group_code', $group_code)->first();
        if($meetingExists)
        return back()->with('danger', 'Meeting details for this group was already defined');

        $meeting = new GroupMeeting();
        $meeting->created_by = $userId;
        $meeting->group_code = $group_code;
        $meeting->group_name = $group_name;
        $meeting->officer = $officer;
        $meeting->day = $request->input('day');
        $meeting->place = $request->input('place');
        $meeting->frequency = $request->input('frequency');
        $meeting->outpost_id = $request->input('outpost_id');
        $meeting->ending_time = $request->input('ending_time');
        $meeting->starting_time = $request->input('starting_time');
        $meeting->additional_info = $request->input('additional_info');
        $meeting->save();

        //Save audit trail
        $activity_type = 'New Group Meeting Creation';
        $description = 'Created meeting details for the group '.$group_code;
        User::saveAuditTrail($activity_type, $description);
        return back()->with('success', 'Meeting details for this group saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'day' => [
                'required',
                'string',
            ],
            'frequency' => [
                'required',
                'string',
            ],
            'starting_time' => [
                'required',
                'string',
            ],
            'ending_time' => [
                'required',
                'string',
            ],
            'place' => [
                'required',
                'string',
            ],
           
        ]);

        $group_name = $request->input('group_name');
        $userId = $request->input('user_id');

        $meeting = GroupMeeting::find($id);
        $meeting->created_by = $userId;
        $meeting->day = $request->input('day');
        $meeting->place = $request->input('place');
        $meeting->frequency = $request->input('frequency');
        $meeting->outpost_id = $request->input('outpost_id');
        $meeting->ending_time = $request->input('ending_time');
        $meeting->starting_time = $request->input('starting_time');
        $meeting->additional_info = $request->input('additional_info');
        $meeting->save();

        //Save audit trail
        $activity_type = 'Group Meeting Updation';
        $description = 'Updated meeting details for the group '.$group_name;
        User::saveAuditTrail($activity_type, $description);
        return back()->with('success', 'Meeting details for this group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = GroupMeeting::find($id);
        $meeting->delete();
        return back()->with('success', 'Meeting details deleted successfully');
    }
}