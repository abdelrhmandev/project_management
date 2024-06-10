<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectClientAttachments extends Model
{
    use HasFactory;
    
    protected $table = 'project_client_attachments';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'file',
        'user_add',
        'user_edit',
        'created_at',
        'updated_at'
    ];
}
