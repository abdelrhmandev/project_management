<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectExploreTour extends Model
{
    protected $table = 'project_explore_tour';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'type_id',
        'project_id',
        'city_id',
        'explore_tour',
        'is_fieldwork_done',
        'is_observer_done',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function type()
    {
        return $this->hasMany(TeamRankType::class, 'id', 'type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
