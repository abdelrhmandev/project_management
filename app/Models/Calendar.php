<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendars';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'className',
    ];
}
