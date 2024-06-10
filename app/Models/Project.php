<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $table = 'projects';
    public $timestamps = true;
    protected $fillable = [
        'status_id',
        'logo',
        'type_id',
        'title',
        'potential_approved_date',
        'is_training_correction',
        'start_date',
        'end_date',
        'cases_count',
        'building_count',
        'customer_id',
        'user_add',
        'user_edit',
        'rfp',
        'additional_questions',
        'requirements_specifications',
        'google_map',
        'opening',
        'opening_reserve_hall',
        'opening_attendance_nature',
        'opening_date',
        'closing',
        'closing_reserve_hall',
        'closing_attendance_nature',
        'closing_date',
        'flexibility_project_dates',
        'executive_planning_file',
        'coordinates',
        'is_client_involved'
    ];

    public function region()
    {
        return $this->belongsToMany(Region::class, 'project_regions');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function type()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function items()
    {
        return $this->belongsToMany(TeamRankItem::class, 'project_team_rank_item');
    }

    public function training()
    {
        return $this->belongsTo(ProjectTrainingType::class);
    }

    public function localDevelopment()
    {
        return $this->hasOne(ProjectLocalDevelopment::class);
    }

    public function ExploreTour()
    {
        return $this->hasOne(ProjectExploreTour::class);
    }

    public function familyDevelopment()
    {
        return $this->hasOne(ProjectFamilyDevelopment::class);
    }


    public function ExecutivePlanning()
    {
        return $this->hasOne(ProjectExecutivePlanning::class);
    }


    public function TrainingType()
    {
        return $this->hasOne(ProjectTrainingType::class);
    }

    public function InspectionVisit()
    {
        return $this->hasOne(ProjectInspectionVisit::class);
    }

    public function EmpowerCharity()
    {
        return $this->hasOne(ProjectEmpowerCharity::class);
    }
}