<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = [
        'name_la',
        'name_en',
        'name_cn',
        'phone',
        'email',
        'address_la',
        'address_en',
        'address_cn',
        'whatapps',
        'facebook',
        'youtube',
        'google_map',
        'play_store',
        'app_store',
        'app_gallery',
        'director_sign',
        'chechker_sign',
        'customer_sign',
        'staff_sign',
        'bill_header',
        'bill_footer'
    ];
}
