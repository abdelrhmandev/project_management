<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $table = 'roles';

    protected $fillable = [
        'name', 'ar_name', 'guard_name'
    ];
}
