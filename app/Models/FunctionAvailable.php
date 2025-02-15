<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FunctionAvailable extends Model
{
    use HasFactory;
    protected $table = 'function_availables';
    protected $fillable = [
        'id',
        'role_id',
        'function_id',
        'created_at',
        'updated_at',
    ];
}
