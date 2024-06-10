<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInspectionVisit extends Model
{
    protected $table = 'project_inspection_visit';
    public $timestamps = true;
    protected $fillable = ['id','project_id','mine_title'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
