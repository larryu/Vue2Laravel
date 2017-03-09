<?php

namespace App\Http\Controllers;

use App\Models\Services\RoleService;
use App\Models\Services\UserService;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\Entities\User;

class UserController extends Controller
{
    private $userService;
    private $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $data = [];
        $data['name'] = $request->user()->name;
        $data['email'] = $request->user()->email;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function show(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles();
        $roleNames = [];
        foreach($roles as $role)
        {
            $roleNames[] = $role->name;
        }
        $roleName = implode(', ', $roleNames);
        $user['role'] = $roleName;
        return $user;
    }
    public function lists(Request $request)
    {
        return $this->user->all();
    }
    /**
     * @param Request $request
     * @return array|null
     */
    public function getUserNodes(Request $request)
    {
        try {
            // 1) first get user from token to check validation
            $user = JWTAuth::parseToken()->authenticate();
            $userNodes = $this->userService->getByPaginate($request);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($userNodes);
    }
    public function updateUser(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name'  =>  'required',
            'email' => 'required|email',
//            'role' => 'required',
//            'group' => 'required'
        ];
        try {
            $this->validate($request, $rules);

            $user = JWTAuth::parseToken()->authenticate();

            $user = $this->userService->update($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('user'));
    }
    public function addUser(Request $request)
    {
        $rules = [
            'name'  =>  'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirmPassword' => 'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $user = $this->userService->add($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('user'));
    }
    public function deleteUser(Request $request)
    {
        $rules = [
            'id'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $user = $this->userService->delete($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('user'));
    }

    public function getRoleOptions(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $roles = $this->userService->getRoleOptions($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('roles'));
    }

    public function getGroupOptions(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $groups = $this->userService->getGroupOptions($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('groups'));
    }
}
