<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRedFlagAttachment extends Model
{
    protected $table = 'project_red_flag_attachment';
    public $timestamps = false;
    protected $fillable = ['id','redflag_id','file'];
 
}



