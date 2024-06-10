<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    public $timestamps = true;
    protected $fillable = ['id', 'type_id', 'title'];

    /**
     * Get all of the comments for the equipments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function type()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
