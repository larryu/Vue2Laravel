<?php

namespace App\Http\Controllers;

use App\Models\Entities\ResourceType;
use App\Models\Services\ComponentService;
use App\Models\Services\PageService;
use App\Models\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ComponentController extends Controller
{
    protected $componentService;
    protected $userService;
    protected $pageService;

    public function __construct(ComponentService $componentService,
                                UserService $userService,
                                PageService $pageService)
    {
        $this->componentService = $componentService;
        $this->userService = $userService;
        $this->pageService = $pageService;
    }

    public function show(Request $request)
    {
        $rules = [
            'pageName' => 'required'
        ];
        $this->validate($request, $rules);
        $pageName = $request->input('pageName');
        $page = $this->pageService->getPageByName($pageName);

        // 1) first get user from token to check validation
        $user = JWTAuth::parseToken()->authenticate();

        // 2) get all components belongs to this page
        $components = $this->componentService->getAll($page->id);
        // 2) get accessible components based on user
        $aclComponents = $this->userService->getAclResourceByType($user, ResourceType::COMPONENT);
        // 3) rebuild $mergedComponents
        // replace the first array with keys on in first array
        // $mergedComponents = array_replace($components, $aclComponents);
        $mergedComponents = array_replace($components, array_intersect_key($aclComponents, $components));
        // 4) rebuild components with name key
        $namedComponents = [];
        foreach($mergedComponents as $component)
        {
            if (isset($namedComponents[$component['name']]))
            {
                //error
                return response()->json([
                    'error' => 'Duplicated component name found in this page!',
                ]);
            }
            else
                $namedComponents[$component['name']] = $component;
        }
        // 5) return components
        return response()->json([
            'components' => json_encode($namedComponents),
        ]);
    }
}
