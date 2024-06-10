<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeamRankItem extends Model
{
    protected $table = 'project_team_rank_item';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'type_id',
        'title',
    ];

    /**
     * Get the user that owns the TeamRankItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function type()
    {
        return $this->belongsTo(TeamRankType::class);
    }
}
