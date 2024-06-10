<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'title',
    ];

    public function _region() {
        return $this->belongsTo(Region::class,'region_id');
     }
}
