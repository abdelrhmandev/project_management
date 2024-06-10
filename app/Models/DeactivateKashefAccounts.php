<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeactivateKashefAccounts extends Model
{
    use HasFactory;

    protected $table = 'deactivate_kashef_accounts';
    public $timestamps = true;
    protected $fillable = ['id','team_user_id','user_id','type_id','project_id','superior_team_id','created_at'];

}
