<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = ['id','name_la','name_en','name_cn','province_id','created_at','updated_at'];

    public function province()
    {
        return $this->belongsTo('App\Models\Province','province_id','id');
    }
}
