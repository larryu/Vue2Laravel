<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

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
    public function getByPaginate($request)
    {
        $sort = $request->sort;
        $sort = explode('|', $sort);

        $sortBy = $sort[0];
        $sortDirection = $sort[1];

        $perPage = $request->per_page;

        $search = $request->search;

        $query = $this->model->orderBy($sortBy, $sortDirection)->where('active',1)->with('usergroups');

        if ($search) {
            $like = "%{$search}%";

            $query = $query->where('name', 'LIKE', $like)
                ->orWhere('email', 'LIKE', $like);
        }

        return $query->paginate($perPage);
    }

}