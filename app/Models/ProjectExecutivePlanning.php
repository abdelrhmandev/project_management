<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExecutivePlanning extends Model
{
    use HasFactory;
    
    protected $table = 'project_executive_planning';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'executive_planning_file',
        'is_approved',
        'is_updated',
        'rejection_file',
        'rejection_note',
        'created_at',
        'updated_at'
    ];
}
