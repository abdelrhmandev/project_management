<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRedFlagReply extends Model
{
    protected $table = 'project_red_flag_replies';
    public $timestamps = true;
    protected $fillable = ['id','reply_user_id','redflag_id', 'reply'];




 
        public function getRedInfo(){
            return $this->belongsTo(ProjectRedFlag::class,'redflag_id','id');
        }






}
