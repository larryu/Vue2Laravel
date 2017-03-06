<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'created_by', 'updated_by', 'updated_at', 'active',
    ];
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id')->where('active',1);
    }
    /**
     * Get all of the menu's resources.
     */
    public function resources()
    {
        return $this->morphMany(GroupResourcePermission::class, 'resource', 'resource_type_id', 'resource_id')->where('active',1);
    }


}
