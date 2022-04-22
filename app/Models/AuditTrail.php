<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuditTrail extends Model
{
    use HasFactory;
    protected $table = 'audit_trails';
    protected $primaryKey = 'trail_id';

    public static function getTrails()
    {
        return DB::table('audit_trails')
                  ->join('users', 'users.id', '=', 'audit_trails.user_id')
                  ->orderBy('trail_id', 'desc')
                  ->get();
    }

}