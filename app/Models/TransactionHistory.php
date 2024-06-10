<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    protected $table = 'transaction_history';
    public $timestamps = true;
    protected $fillable = ['title', 'previous', 'class','icons']; 
}
