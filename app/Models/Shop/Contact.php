<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'name',
        'email',
        'message',
        'subject',
        'mobile_no',
    ];

    public static function getContacts()
    {
        return DB::table('contacts')
                  ->orderBy('contact_id', 'desc')
                  ->get();
    }
}