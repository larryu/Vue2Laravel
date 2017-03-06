<?php

namespace App\Http\Controllers;

use App\Models\Entities\ResourceType;
use App\Models\Services\TabService;
use App\Models\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;

class TabController extends Controller
{
    protected $tabService;
    protected $userService;

    public function __construct(TabService $tabService, UserService $userService)
    {
        $this->tabService = $tabService;
        $this->userService = $userService;
    }

    public function show(Request $request)
    {
        // 1) first get user from token to check validation
        $user = JWTAuth::parseToken()->authenticate();

        // 2) get all tabs
        $tabs = $this->tabService->getAll();

        // 2) get accessible tabs based on user
        $aclTabs = $this->userService->getAclResourceByType($user, ResourceType::TAB);

        // 3) rebuild tabs
        $mergedTabs = array_replace($tabs, $aclTabs);

        // 4) return tabs
        return response()->json([
            'tabs' => $mergedTabs,
        ]);
    }
}
