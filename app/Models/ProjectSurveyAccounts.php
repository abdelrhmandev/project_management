<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSurveyAccounts extends Model
{
    protected $table = 'project_survey_accounts';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'project_id',
        'admin_email',
        'admin_password',
        'url'
    ];
}
