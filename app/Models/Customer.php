<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'principal_name',
        'principal_position',
        'principal_mobile',
        'principal_email',
        'user_id'
    ];

    /**
     * Get all of the comments for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
