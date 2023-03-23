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
        $categories = TicketCategory::orderBy('category_name', 'asc')->get();
        for ($s=0; $s <count($categories) ; $s++) { 
            $categories[$s]->count = CustomerTicket::where('category_id', $categories[$s]->category_id)->count();
        }
        return $categories;
    }
}
