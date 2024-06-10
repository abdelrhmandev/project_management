<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $table = 'equipment_types';
    public $timestamps = false;
    protected $fillable = ['title'];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
}
