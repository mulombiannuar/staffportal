<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;
    protected $table = 'ticket_categories';
    protected $primaryKey = 'category_id';


    public static function getCategories()
    {
        return TicketCategory::orderBy('category_name', 'asc')->get();
    }
}
