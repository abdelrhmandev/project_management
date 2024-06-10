<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFinancialEstimate extends Model
{
    protected $table = 'project_financial_estimate';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'start_date',
        'end_date',
        'beneficiary_preparation_pricing',
        'writing_report_cost',
        'is_family_list_required',
        'is_coordinate_required',
        'is_explore_tour_required',
        'start_date',
        'observer_training_date',
        'inspector_visit_date',
        'observer_qty',
        'observer_price',
        'observer_audit_qty',
        'observer_audit_price',
        'auditor_qty',
        'auditor_price',
        'supervisor_qty',
        'supervisor_price',
        'researcher_qty',
        'researcher_price',
        'inspector_qty',
        'inspector_price',
        'trainer_qty',
        'trainer_price',
        'is_espeical_training_needed',
        'observer_training_required',
        'auditor_training_required',
        'finacne_file'
    ];
}
