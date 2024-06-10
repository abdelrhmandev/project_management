<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'national_id',
        'username',
        'email',
        'password',
        'avatar',
        'active_status',
        'region_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleId()
    {
        return auth()->user()->roles->first()->id ?? '-';
    }

    public function getRoleNames()
    {
        return $this->roles->pluck('ar_name');
    }

    public function getRoletitle()
    {
        return auth()->user()->roles->pluck('ar_name')[0] ?? '-';
    }

    public function getRoleDirUrl()
    {
        return auth()->user()->roles->pluck('name')[0] ?? '-';
    }

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = bcrypt($password);
    }

    public function type()
    {
        return $this->hasMany(TeamRankType::class, 'id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
