<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTransactionHistory extends Model
{
    protected $table = 'project_transaction_history';
    public $timestamps = true;
    protected $fillable = ['user_id','project_id', 'status_id', 'is_done', 'created_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(TransactionHistory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
