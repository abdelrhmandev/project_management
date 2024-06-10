<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectedProject extends Model
{
    protected $table = 'rejected_project';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'reason',
    ];
}
