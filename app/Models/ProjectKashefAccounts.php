<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectKashefAccounts extends Model
{
    protected $table = 'project_kashef_accounts';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'project_id',
        'admin_email',
        'admin_password',
        'report_email',
        'report_password',
        'studies_email',
        'studies_password',
        'url'
    ];
}
