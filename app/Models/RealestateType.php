<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealestateType extends Model
{
    protected $table = 'realestate_type';
    public $timestamps = false;
    protected $fillable = ['title'];

    public function contractResearchItem()
    {
        return $this->belongsTo(ProjectContractResearchItem::class, 'id');
    }
}
