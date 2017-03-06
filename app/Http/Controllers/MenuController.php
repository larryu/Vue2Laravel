<?php

namespace App\Http\Controllers;

use App\Models\Entities\ResourceType;
use App\Models\Services\MenuService;
use App\Models\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MenuController extends Controller
{
    protected $menuService;
    protected $userService;

    public function __construct(MenuService $menuService, UserService $userService)
    {
        $this->menuService = $menuService;
        $this->userService = $userService;
    }

    public function show(Request $request)
    {
        try {
            // 1) first get user from token to check validation
            $user = JWTAuth::parseToken()->authenticate();
            // 2) get all menus
            $menus = $this->menuService->getAll();

            // 3) get accessible menus based on user
            $aclMenus = $this->userService->getAclResourceByType($user, ResourceType::MENU);

            // 3) rebuild menus
            $mergedMenus = array_replace($menus, $aclMenus);
            // 4) build tree menus
            $treeMenus = $this->menuService->getTreeMenus($mergedMenus, 'parent_id', 'id');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'menus' => $treeMenus,
        ]);
    }
    /**
     * @param Request $request
     * @return array|null
     */
    public function getMenuNodes(Request $request)
    {
        try {
            // 1) first get user from token to check validation
            $user = JWTAuth::parseToken()->authenticate();
            // 2) get all menus
            $menuNodes= $this->menuService->getAllMenuNodes();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'menuNodes' => $menuNodes,
        ]);
    }
    public function updateMenu(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);

            $user = JWTAuth::parseToken()->authenticate();

            $menu = $this->menuService->update($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('menu'));
    }
    public function addMenu(Request $request)
    {
        $rules = [
            'name'  =>  'required',
            'parent_id' => 'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $menu = $this->menuService->add($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('menu'));
    }
    public function deleteMenu(Request $request)
    {
        $rules = [
            'id'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $menu = $this->menuService->delete($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('menu'));
    }

}
