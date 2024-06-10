<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequirements extends Model
{
    use HasFactory;
    protected $table = 'project_requirements';
    public $timestamps = true;
    protected $guarded = [];
}
