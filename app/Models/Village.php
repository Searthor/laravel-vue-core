<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'villages';
    protected $fillable = ['id', 'name_la', 'name_en','name_cn', 'district_id'];

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
}
