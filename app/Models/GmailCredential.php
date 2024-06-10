<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GmailCredential extends Model
{
    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $table = 'gmails_credential';
    public $timestamps = false;
    protected $fillable = ['name','email','password'];
}
