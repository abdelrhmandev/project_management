<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingUrl extends Model
{
    protected $table = 'training_url';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'type_id',
        'project_id',
        'is_correction',
        'start_date',
        'end_date',
        'url',
        'train_file_url',
        'train_kashef_url',
        'train_kashef_account_email',
        'train_kashef_account_password'
    ];
}
