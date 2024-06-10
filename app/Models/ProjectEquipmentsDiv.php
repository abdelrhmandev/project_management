<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEquipmentsDiv extends Model
{
    use HasFactory;
    protected $table = 'project_equipments_division';
    public $timestamps = false;
    protected $fillable = ['id', 'equipment_id', 'equipment_type', 
    'project_id', 'amount', 'observer_id','notes','files','shipment_files','is_agree','rejection_reason','created_at','updated_at'];
}

