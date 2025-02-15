<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FunctionModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
        'des'
    ];

    public function children()
    {
        return $this->hasMany(FunctionModel::class, 'parent_id');
    }

    // Relationship to fetch grandchildren
    public function grandchildren()
    {
        return $this->hasMany(FunctionModel::class, 'parent_id')->with('children');
    }
}
