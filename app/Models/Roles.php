<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'id',
        'name',
        'des',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with the FunctionAvailable model (assuming there's a foreign key role_id in the function_available table)
    public function functionAvailable()
    {
        return $this->hasMany(FunctionAvailable::class, 'role_id');
    }
}
