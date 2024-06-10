<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEquipments extends Model
{
    protected $table = 'project_equipments';
    public $timestamps = false;
    protected $fillable = ['id', 'equipment_id', 'equipment_type', 'project_id', 'qty', 'price'];
}
