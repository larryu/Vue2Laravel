<?php

namespace App\Http\Controllers;

use App\Models\Services\RoleService;
use App\Models\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class RoleController extends Controller
{
    protected $roleService;
    protected $userService;
    public function __construct(RoleService $roleService, UserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    public function lists(Request $request)
    {
        // 1) first get user from token to check validation
        $user = JWTAuth::parseToken()->authenticate();

         // 2) get current roles
        $roles = $this->userService->getRoles($user);

        // // 3) check whether the roles have children
        // $rawSql = "
        //         WITH ret AS(
        //           SELECT  *
        //           FROM    roles
        //           WHERE   id = ?
        //           UNION ALL
        //           SELECT  t.*
        //           FROM  roles t INNER JOIN
        //                 ret r ON t.parent_id = r.id
        //         )
        //         SELECT  *
        //         FROM    ret order by id asc
        // ";

        // $roleRets = [];
        // foreach($roles as $role)
        // {
        //     if ($role->canEdit) {
        //         $rets = DB::select($rawSql, array($role->id));
        //         $rets = json_decode(json_encode($rets), true);
        //         if (count($rets) > 0) {
        //             $treeRoles = Role::getTreeRoles($rets, 'parent_id', 'id');
        //             $roleRets[$role->id] = $treeRoles;
        //         }
        //     }
        // }
        //2) get all components belongs to this page
        // $rolesAll= Role::where('active', 1)->get()->keyBy('id')->toArray();
        // $retRoles = [];
        $treeRoles = $this->roleService->getChildRoles($user);

        // 4) return processes
        return response()->json([
            'assingedRoles' => json_encode($roles),
            'childRoles' => json_encode($treeRoles),
        ]);

    }

    public function updateRole(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name'  =>  'required',
        ];

        $this->validate($request, $rules);

        $user = JWTAuth::parseToken()->authenticate();

        $role = $this->roleService->update($request);

        return response()->json(compact('role'));
    }
    public function addRole(Request $request)
    {
        $rules = [
            'name'  =>  'required',
            'parent_id' => 'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $role = $this->roleService->add($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('role'));
    }
    public function deleteRole(Request $request)
    {
        $rules = [
            'id'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $role = $this->roleService->delete($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('role'));
    }
}
