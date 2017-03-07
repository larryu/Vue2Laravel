<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
//use App\Models\Entities\ResourceType;

class Group extends Model
{
    /**
     * Get the roles that has the group.
     */
    public function role()
    {
        return $this->belongsTo(Role::class)->where('active',1);
    }

    /**
     * Get the group resource permission associated with the group.
     */
    public function groupResourcePermissions()
    {
        return $this->hasMany(GroupResourcePermission::class)->where('active',1);
    }
    /**
     * Get the group resource permission associated with the group.
     * @param $resTypeId
     * @return array
     */
    public function groupResourcePermissionsByType($resTypeId)
    {
        $resType = [];
        foreach($this->groupResourcePermissions as $item)
        {
            if ($item->resource_type_id == $resTypeId)
                $resType[] = $item;
        }
        return $resType;
    }

    /**
     * Get the group menu resource permission associated with the group.
     */
    public function groupMenuResourcePermissions()
    {
        $resMenus = [];
        foreach($this->groupResourcePermissions as $item)
        {
            if ($item->resource_type_id == ResourceType::MENU)
                $resMenus[] = $item;
        }
        return $resMenus;
    }
    /**
     * Get the group tab resource permission associated with the group.
     */
    public function groupTabResourcePermissions()
    {
        $resTabs = [];
        foreach($this->groupResourcePermissions as $item)
        {
            if ($item->resource_type_id == ResourceType::TAB)
                $resTabs[] = $item;
        }
        return $resTabs;
    }
    /**
     * Get the group component resource permission associated with the group.
     */
    public function groupComponentResourcePermissions()
    {
        $resComponents = [];
        foreach($this->groupResourcePermissions as $item)
        {
            if ($item->resource_type_id == ResourceType::COMPONENT)
                $resComponents[] = $item;
        }
        return $resComponents;
    }
}
