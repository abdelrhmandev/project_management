<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFamilyDevelopment extends Model
{
    protected $table = 'project_family_development';
    public $timestamps = true;
    protected $fillable = [
    'id',
    'project_id',
    'family_list',
    'user_add',
    'user_edit'
];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
