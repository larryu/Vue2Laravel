<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class GroupResourcePermission extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_resource_permission';


    /**
     * Get the groups that has the group.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->where('active',1);
    }
    /**
     * Get the permissions that has the group.
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class)->where('active',1);
    }
    /**
     * Get all of the owning resource models.
     */
    public function resource()
    {
        return $this->morphTo('resource', 'resource_type_id', 'resource_id')->where('active',1);
    }
    /**
     * Get all menu resource
     */
    public function menus()
    {

    }
}
