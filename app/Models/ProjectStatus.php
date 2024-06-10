<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    protected $table = 'project_status';
    public $timestamps = true;
    protected $fillable = ['title','trans','history','class']; 

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
