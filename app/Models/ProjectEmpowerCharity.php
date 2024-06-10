<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEmpowerCharity extends Model
{
    protected $table = 'project_empower_charity';
    public $timestamps = true;
    protected $fillable = [
    'id',
    'project_id',
    'user_add',
    'user_edit',
    'charity_count',
    'charity_list_file'
];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
