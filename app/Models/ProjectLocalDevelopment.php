<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectLocalDevelopment extends Model
{
    protected $table = 'project_local_development';
    public $timestamps = true;
    protected $fillable = [
    'id',
    'project_id',
    'research_survey',
    'coordinate_file',
    'user_add',
    'user_edit'
];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
