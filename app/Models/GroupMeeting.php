<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupMeeting extends Model
{
    use HasFactory;
    protected $table = 'group_meetings';
    protected $primaryKey = 'meeting_id';

    public function getMeetingsByUserId($user_id)
    {
        return  DB::table('group_meetings')
                ->join('users', 'users.id', '=', 'group_meetings.created_by')
                //->join('groups', 'groups.GroupID', '=', 'group_meetings.group_code')
                ->join('outposts', 'outposts.outpost_id', '=', 'group_meetings.outpost_id')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'group_meetings.*',
                    'outposts.*',
                    'branches.*',
                    'users.name',
                    )
                ->where('created_by', $user_id)
                ->orderBy('day', 'asc')
                ->get();
    }
}