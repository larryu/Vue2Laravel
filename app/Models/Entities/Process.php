<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    /**
     * Get all of the process's resources.
     */
    public function resources()
    {
        return $this->morphMany(GroupResourcePermission::class, 'resource', 'resource_type_id', 'resource_id')->where('active',1);
    }

    /**
     * Get the component which the process belongs to
     * @return mixed
     */
    public function component()
    {
        return $this->belongsTo(Component::class)->where('active',1);
    }
}
