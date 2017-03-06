<?php

namespace App\Models\Services;

use App\Models\Entities\User;
use App\Models\Entities\Permission;
use App\Models\Entities\ResourceType;
use App\Models\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getRoles($user)
    {
        return $this->userRepository->getRoles($user);
    }
    /**
     * Get accessible menus
     * @return array
     */
    public function getAclMenus()
    {
        $menus = [];
        $groups = $this->userRepository->groups();
        foreach($groups as $group)
        {
            //$resMenus = $group->groupMenuResourcePermissions();
            $resMenus = $group->groupResourcePermissionsByType(ResourceType::MENU);
            foreach($resMenus as $resMeu)
            {
                //$newObj = new \stdClass();
                $newObj = $resMeu->resource;
                $newObj->permission = $resMeu->permission->name;
                if (isset($menus[$newObj->id]))
                {
                    $existingMenu = $menus[$newObj->id];
                    $existingMenu['permission'] = Permission::getHigherPermission($existingMenu['permission'],
                        $newObj->permission);
                }
                else
                    $menus[$newObj->id] = $newObj->toArray();
            }
        }
        return $menus;
    }
    /**
     * Get accessible tabs
     * @return array
     */
    public function getAclTabs()
    {
        $tabs = [];
        $groups = $this->groups();

        foreach($groups as $group)
        {
            //$resTabs = $group->groupTabResourcePermissions();
            $resTabs = $group->groupResourcePermissionsByType(ResourceType::TAB);
            foreach($resTabs as $resTab)
            {
                //$newObj = new \stdClass();
                $newObj = $resTab->resource;
                $newObj->permission = $resTab->permission->name;
                if (isset($tabs[$newObj->id]))
                {
                    $existingTab = $tabs[$newObj->id];
                    $existingTab['permission'] = Permission::getHigherPermission($existingTab['permission'],
                        $newObj->permission);
                }
                else
                    $tabs[$newObj->id] = $newObj->toArray();
            }
        }
        return $tabs;
    }
    /**
     * Get accessible components
     * @return array
     */
    public function getAclComponents()
    {
        $components = [];
        $groups = $this->groups();

        foreach($groups as $group)
        {
            $resComponents = $group->groupResourcePermissionsByType(ResourceType::COMPONENT);
            foreach($resComponents as $resComponent)
            {
                //$newObj = new \stdClass();
                $newObj = $resComponent->resource;
                $newObj->permission = $resComponent->permission->name;
                if (isset($components[$newObj->id]))
                {
                    $existingComponent = $components[$newObj->id];
                    $existingComponent['permission'] = Permission::getHigherPermission($existingComponent['permission'],
                        $newObj->permission);
                }
                else
                    $components[$newObj->id] = $newObj->toArray();
            }
        }
        return $components;
    }
    /**
     * Get accessible processes
     * @return array
     */
    public function getAclProcesses()
    {
        $processes = [];
        $groups = $this->groups();

        foreach($groups as $group)
        {
            $resProcesses= $group->groupResourcePermissionsByType(ResourceType::PROCESS);
            foreach($resProcesses as $resProcesse)
            {
                $newObj = $resProcesse->resource;
                $newObj->permission = $resProcesse->permission->name;
                if (isset($processes[$newObj->id]))
                {
                    $existingProcess = $processes[$newObj->id];
                    $existingProcess['permission'] = Permission::getHigherPermission($existingProcess['permission'],
                        $newObj->permission);
                }
                else
                    $processes[$newObj->id] = $newObj->toArray();
            }
        }
        return $processes;
    }

    /**
     * @param User $user
     * @param $resourceType
     * @return array
     */
    public function getAclResourceByType(User $user, $resourceType)
    {
        $resRets = [];
        $groups = $user->groups();

        foreach($groups as $group)
        {
            $resources= $group->groupResourcePermissionsByType($resourceType);
            foreach($resources as $resource)
            {
                $newObj = $resource->resource;
                $newObj->permission = $resource->permission->name;
                if (isset($resRets[$newObj->id]))
                {
                    $existingRes = $resRets[$newObj->id];
                    $existingRes['permission'] = Permission::getHigherPermission($existingRes['permission'],
                        $newObj->permission);
                }
                else
                    $resRets[$newObj->id] = $newObj->toArray();
            }
        }
        return $resRets;
    }

}