<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectContractResearchItem extends Model
{
    protected $table = 'project_contract_research_items';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'title',
        'price',
        'realestate_id',
        'project_id',
        'notices',
    ];

    public function realestateType()
    {
        return $this->hasMany(RealestateType::class, 'id', 'realestate_id');
    }
}
