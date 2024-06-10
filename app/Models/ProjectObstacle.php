<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectObstacle extends Model
{
    protected $table = 'project_obstacles';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'project_id',
        'user_id',
        'sender_id',
        'type_id',
        'icon',
        'title',
        'message',
        'is_close',
    ];
}