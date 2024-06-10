<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRedFlagReplyAttachment extends Model
{
    protected $table = 'project_red_flag_reply_attachments';
    public $timestamps = false;
    protected $fillable = ['id','redflag_id','file'];
 
}



