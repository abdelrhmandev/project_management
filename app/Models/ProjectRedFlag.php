<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRedFlag extends Model
{
    protected $table = 'project_red_flags';
    public $timestamps = true;
    protected $fillable = ['id', 'status', 'project_id', 'client_id', 'title'];

    public function getClientInfo()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(ProjectRedFlagReply::class, 'redflag_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(ProjectRedFlagAttachment::class, 'redflag_id', 'id');
    }

    public function getReplyAttachments()
    {
        return $this->hasManyThrough(
            ProjectRedFlagReplyAttachment::class,
            ProjectRedFlagReply::class,
            'redflag_id', 'red_flag_reply_id');
    }
}