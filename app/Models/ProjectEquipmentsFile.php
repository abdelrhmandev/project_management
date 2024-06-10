<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEquipmentsFile extends Model
{
    protected $table = 'project_equipments_files';
    public $timestamps = false;
    protected $fillable = ['id', 'equipment_type', 'project_id','user_id','file'];
}
