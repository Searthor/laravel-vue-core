<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
    public function village()
    {
        return $this->belongsTo('App\Models\Village', 'vill_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'dis_id', 'id');
    }
    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'pro_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'gender',
        'status',
        'email',
        'password',
        'role_id',
        'branches_id',
        'vill_id',
        'dis_id',
        'pro_id',
        'del'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
