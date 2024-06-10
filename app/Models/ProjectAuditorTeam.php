<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAuditorTeam extends Model
{
    protected $table = 'project_auditor_team';
    public $timestamps = true;
    protected $fillable = [
        'team_user_id',
        'superior_id',
        'type_id',
        'project_id',
        'is_correction',
        'qty',
        'received_train',
        'approved_member',
        'created_kashef'
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function atttractingTeamInfo()
    {
        return $this->belongsTo(AttractingTeam::class, 'team_user_id', 'id');
    }
}