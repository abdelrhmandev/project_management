<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEvaluation extends Model
{
    use HasFactory;
    protected $table = 'project_evaluations';
    public $timestamps = false;
    protected $fillable = [
        'id', 
        'team_user_id',
        'type_id',
        'user_id',
        'project_id', 
        'evaluate',
        'created_at'
        ];
}

