<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTrainingDetail extends Model
{
    protected $table = 'Project_training_detail';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'is_trainers_needed',
        'training_date',
        'file'
    ];
}
