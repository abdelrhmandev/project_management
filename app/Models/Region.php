<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'title',
    ];

    public function _city() {
       return $this->hasMany(City::class,'region_id');
    }
}
