<?php

namespace App\Models\Services;

use App\Models\Entities\User;
use App\Models\Entities\Permission;
use App\Models\Repositories\RoleRepository;
use App\Models\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository,
                                RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    public function getRoles($user)
    {
        return $this->userRepository->getRoles($user);
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
    public function getAllUserNodes()
    {
        return $this->userRepository->getAllUserNodes();
    }
    public function update($request)
    {
        return $this->userRepository->save($request);
    }
    public function add($request)
    {
        return $this->userRepository->add($request);
    }
    public function delete($request)
    {
        return $this->userRepository->delete($request);
    }
    public function getByPaginate(Request $request)
    {
        return $this->userRepository->getByPaginate($this->roleRepository, $request);
    }
}