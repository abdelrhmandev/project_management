<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractingTeam extends Model
{
    protected $table = 'attracting_team';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'name',
        'national_id',
        'type_id',
        'performance_percentage',
        'region_id',
        'city_id',
        'email',
        'is_processed'
    ];

    public function type()
    {
        return $this->belongsTo(TeamRankType::class, 'type_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
