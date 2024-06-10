<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFieldworkTeam extends Model
{
    protected $table = 'project_fieldwork_team';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'type_id',
        'project_id',
        'supervisor_qty',
        'researcher_qty',
        'old_supervisor_qty',
        'old_researcher_qty',
        'auditor_qty'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function type()
    {
        return $this->hasMany(TeamRankType::class, 'id', 'type_id');
    }
}
