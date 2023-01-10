<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'clients';
    protected $primaryKey = 'client_id';

    public static function getClientById($client_id)
    {
        return Client::join('users', 'users.id', '=', 'clients.created_by')
                ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                ->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                ->where(['client_id'=> $client_id])
                ->first();
    }

    public static function getClients()
    {
        return Client::join('users', 'users.id', '=', 'clients.created_by')
                     ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                     ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                     ->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                     ->orderBy('bimas_br_id', 'asc')
                     ->get();
    }

    public static function getClientsByOutpost($outpost_id)
    {
        return Client::where('outpost_id', $outpost_id)->orderBy('bimas_br_id', 'asc')->get();
    }

    public static function getClientsByBranch($branch_id)
    {
        return Client::where('branch_id', $branch_id)->orderBy('bimas_br_id', 'asc')->get();
    }
}
