<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObstacleMesages extends Model
{
    protected $table = 'obstacle_messages';
    public $timestamps = true;
    protected $fillable = [
        'obstacle_id',
        'user_id',
        'sender_id',
        'message',
    ];
}
