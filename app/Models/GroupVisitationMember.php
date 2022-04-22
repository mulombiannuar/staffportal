<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupVisitationMember extends Model
{
    use HasFactory;
    protected $table = 'group_visitation_members';
    protected $primaryKey = 'member_id';

    public function getMembersByActivityType($id, $type)
    {
       return DB::table('group_visitation_members')
                ->where([
                    'visit_id' => $id, 
                    'activity_type' => $type
                    ])
                ->get();;
    }
}