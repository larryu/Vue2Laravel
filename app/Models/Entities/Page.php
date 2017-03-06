<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * Get all of the page's resources.
     */
    public function resources()
    {
        return $this->morphMany(GroupResourcePermission::class, 'resource', 'resource_type_id', 'resource_id')->where('active',1);
    }
}
