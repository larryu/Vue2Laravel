<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    /**
     * Get all of the component's resources.
     */
    public function resources()
    {
        return $this->morphMany(GroupResourcePermission::class, 'resource', 'resource_type_id', 'resource_id')->where('active',1);
    }
    /**
     * Get the process associated with the component.
     */
    public function processes()
    {
        return $this->hasMany(Process::class)->where('active',1);
    }
}
