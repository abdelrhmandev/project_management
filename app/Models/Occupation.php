<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    protected $table = 'occupations';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'title',
    ];
}
