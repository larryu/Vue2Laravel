<?php

namespace App\Models\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use App\Models\Entities\Role;
use DB;
class RoleRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\Role';
    }
//    public function getAll($pageId)
//    {
//        return $this->model->where('active', 1)->where('page_id', $pageId)
//            ->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();
//    }
//    /**
//     * @param $flat
//     * @param $pidKey
//     * @param null $idKey
//     * @return mixed
//     */
//    static public function getTreeRoles($flat, $pidKey, $idKey = null)
//    {
//        $grouped = array();
//        $first = $flat[key($flat)];
//        $rootId = $first['parent_id'];
//        $level = 0;
//        foreach ($flat as $sub) {
//            $grouped[$sub[$pidKey]][] = $sub;
//        }
//        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey, &$level) {
//            $level++;
//            foreach ($siblings as $k => $sibling) {
//                $id = $sibling[$idKey];
//                if(isset($grouped[$id])) {
//                    $sibling['children'] = $fnBuilder($grouped[$id]);
//                    $level--;
//                }
//                $siblings[$k] = $sibling;
//                $siblings[$k]['level'] = $level;
//            }
//            return $siblings;
//        };
//        $tree = $fnBuilder($grouped[$rootId]);
//
//        return $tree;
//    }
//
//    static public function getChildrenRoles($ary, $role)
//    {
//        $results = array();
//
//        foreach($ary as $el)
//        {
//            if ($el['parent_id'] == $role->id)
//            {
//                $results[] = $el;
//            }
//            if (count($el['children']) > 0 && ($children = getChildrenRoles($el['children'], $role)) !== FALSE)
//            {
//                $results = array_merge($results, $children);
//            }
//        }
//
//        return count($results) > 0 ? $results : array();
//    }
    public function add($request)
    {
        $role =  new Role();
        $role->parent_id = $request->input('parent_id');
        $role->name = $request->input('name');
        $role->comment = $request->input('comment');
        $role->save();
        return $role;
    }
    public function save($request)
    {
        $role =  $this->model->findOrFail($request->input('id'));
        $role->name = $request->input('name');
        $role->comment = $request->input('comment');
        $role->save();
        return $role;
    }
    public function delete($request)
    {
        $role =  $this->model->findOrFail($request->input('id'));

        // 1) check whether this role has children if yes cannot be deleted
        $childrenRole = $this->findAllBy('parent_id', $role->id);
        if (count($childrenRole) > 0)
        {
            throw new \Exception('You Cannot delete this role because it has children roles.');
        }
        // 2) check whether there are users assigned to this role if yes cannot be deleted
        $users = $this->getUsersOfRole($role);
        if (count($users) > 0)
        {
            throw new \Exception('You Cannot delete this role because it has relevant users.');
        }
        $role->active = 0;
        $role->save();
        return $role;
    }
    /**
     * @param $user
     * @return array
     */
    public function getChildRoles($user)
    {
        $roles = $user->roles();
        $treeRoles = [];
        foreach($roles as $role)
        {
            $retRoles = [];
            $retRoles = $this->getAllChildren($role, $retRoles, $role->id);
            $treeRoles[$role->name] = $retRoles;
        }
        return $treeRoles;
    }

    /**
     * @param $role
     * @param null $result
     * @param int $starting
     * @return array|null
     */
    public function getAllChildren($role, &$result = null, $starting = 0)
    {
        if($starting === 0) // initiate recursive function
        {
            $starting = $role->id;
            $result = array();
        }
        else $result[$role->id] = $this->model->with('parent')->where('active', 1)->find($role->id)->toArray();

        $children = $this->model->where('parent_id', $role->id)->where('active', 1)->get();
        foreach ($children as $child)
        {
            $this->getAllChildren($child, $result, $child->id);
        }
        return $result;
    }

    /**
     * get associated users belong to the role
     * @param $role
     * @return mixed
     */
    public function getUsersOfRole($role)
    {
        $users = DB::table('user_group')->join('groups', 'groups.id', '=', 'user_group.group_id')
            ->join('roles', 'roles.id', '=', 'groups.role_id')
            ->where('roles.id', $role->id)
            ->select('user_group.user_id')->get();
        return $users;
    }
}