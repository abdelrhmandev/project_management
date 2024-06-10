<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectObserverTeam extends Model
{
    protected $table = 'project_observer_team';
    public $timestamps = true;
    protected $fillable = [
        'team_user_id',
        'superior_id',
        'superior_team_id',
        'type_id',
        'project_id',
        'city_id',
        'is_correction',
        'qty',
        'training_url_sent',
        'received_train',
        'approved_member',
        'created_kashef',
        'is_good',
        'notes',
        'equipments'
    ];

    public function teamSuperior()
    {
        return $this->hasMany(AttractingTeam::class, 'id', 'superior_team_id');
    }

    public function superior()
    {
        return $this->hasMany(User::class, 'id', 'superior_id');
    }

    public function user()
    {
        return $this->hasMany(AttractingTeam::class, 'id', 'team_user_id');
    }

    public function type()
    {
        return $this->hasMany(TeamRankType::class, 'id', 'type_id');
    }

    public function children()
    {
        return $this->hasMany(ProjectObserverTeam::class, 'superior_team_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('children');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function atttractingTeamInfo()
    {
        return $this->belongsTo(AttractingTeam::class, 'team_user_id', 'id');
    }
}