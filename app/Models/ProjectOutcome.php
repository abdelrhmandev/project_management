<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOutcome extends Model
{
    use HasFactory;
    protected $table = 'project_outcome';
    public $timestamps = true;
    protected $guarded = [];
}
