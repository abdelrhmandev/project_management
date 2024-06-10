<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTrainingType extends Model
{
    protected $table = 'project_training_type';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'project_id',
        'training_count',
        'training_type',
        'training_headquarter',
        'participant_type',
        'duration',
        'training_date',
        'training_on',
        'is_hall_required',
        'user_add',
        'user_edit',
        'training_agenda',
        'trainee_list',
        'trainer_id',
        'training_material',
        'training_report',
        'updated_at',
        'created_at'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'trainer_id');
    }
}
