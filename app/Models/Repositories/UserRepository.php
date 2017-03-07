<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;
use App\Models\Entities\Role;

class UserRepository extends Repository
{
    public function model() {
        return 'App\Models\Entities\User';
    }
    /**
     * @param $user
     * @return mixed
     */
    public function getRoles($user)
    {
        return $user->roles();
    }
    public function getAllUserNodes()
    {
        // return $this->model->where('active',1)->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();
//        $users = DB::table('user_group')->join('groups', 'groups.id', '=', 'user_group.group_id')
//            ->join('roles', 'roles.id', '=', 'groups.role_id')
//            ->where('roles.id', $role->id)
//            ->select('user_group.user_id')->get();
        return $this->model->where('active',1)->with('usergroups')
            ->get()->keyBy('id')->toArray();
        return $users;
    }
    public function add($request)
    {
        $user =  new User();
        $user->name = $request->input('name');
        $user->comment = $request->input('comment');
        $user->email = $request->input('email');
        $user->save();
        return $user;
    }
    public function save($request)
    {
        $user =  $this->model->findOrFail($request->input('id'));
        $user->name = $request->input('name');
        $user->comment = $request->input('comment');
        $user->email = $request->input('email');
        $user->save();
        return $user;
    }
    public function delete($request)
    {
        $user =  $this->model->findOrFail($request->input('id'));
        $user->active = 0;
        $user->save();
        return $user;
    }
    public function getByPaginate(RoleRepository $roleRepository, $request)
    {

        $selectedRole = $request->selectedRole;

        $selectedRole = Role::where('name', $selectedRole)->first();

        $roleIds = $roleRepository->getAllChildrenIds($selectedRole);

        $userIds = [];

        foreach($roleIds as $roleId)
        {
            $retUsers = $this->getUsersOfRole($roleId);
            foreach($retUsers as $retUser)
            {
                $userIds[] = $retUser;
            }
        }
        $userIds = array_unique($userIds);
        $sort = $request->sort;
        $sort = explode('|', $sort);

        $sortBy = $sort[0];
        $sortDirection = $sort[1];

        $perPage = $request->per_page;

        $search = $request->filter;

        $query = $this->model->orderBy($sortBy, $sortDirection)
                    ->where('active',1)
                    ->wherein('id', $userIds)
                    ->with('usergroups');

        if ($search) {
            $like = "%{$search}%";

            $query = $query->where(function ($query) use ($like) {
                            $query->where('name', 'LIKE', $like)
                                ->orWhere('email', 'LIKE', $like);
                    });
        }

        return $query->paginate($perPage);
    }
    /**
     * get associated users belong to the role
     * @param $role
     * @return mixed
     */
    public function getUsersOfRole($roleId)
    {
        $users = DB::table('user_group')->join('groups', 'groups.id', '=', 'user_group.group_id')
            ->join('roles', 'roles.id', '=', 'groups.role_id')
            ->where('roles.id', $roleId)->distinct()
            ->select('user_group.user_id as id')->get()->toArray();
        $userIds = [];
        foreach($users as $user)
        {
            $userIds[] = $user->id;
        }
        return $userIds;
    }

}