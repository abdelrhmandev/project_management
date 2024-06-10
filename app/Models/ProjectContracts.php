<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectContracts extends Model
{
    protected $table = 'project_contracts';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'type_id',
        'team_user_id',
        'user_id',
        'contract_url',
        'approved',
        'send_date',
        'rejection_reason',
    ];

    public function atttractingTeamInfo()
    {
        return $this->belongsTo(AttractingTeam::class, 'team_user_id', 'id')->where('type_id', 3);
    }
}
