<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTourFile extends Model
{
    protected $table = 'project_tour_file';
    public $timestamps = true;
    protected $fillable = [
        'explore_tour_id',
        'file_type',
        'file'
    ];
}
