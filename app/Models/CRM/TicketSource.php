<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSource extends Model
{
    use HasFactory;
    protected $table = 'ticket_sources';
    protected $primaryKey = 'source_id';

    public static function getSources()
    {
        return TicketSource::orderBy('source_name', 'asc')->get();
    }
}
