<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $table = 'project_types';
    public $timestamps = false;
    protected $fillable = ['title', 'icon'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
