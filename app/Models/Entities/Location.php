<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Get all of the location's resources.
     */
    public function resources()
    {
        return $this->morphMany(GroupResourcePermission::class, 'resource', 'resource_type_id', 'resource_id')->where('active',1);
    }
}
