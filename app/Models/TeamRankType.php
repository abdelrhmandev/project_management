<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRankType extends Model
{
    protected $table = 'team_rank_types';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'title',
        'trans'
    ];
}
