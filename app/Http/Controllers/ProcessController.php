<?php
namespace App\Http\Controllers;

use App\Models\Entities\ResourceType;
use App\Models\Services\ComponentService;
use App\Models\Services\ProcessService;
use App\Models\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProcessController extends Controller
{
    protected $processService;
    protected $userService;
    protected $componentService;

    public function __construct(ProcessService $processService,
                                UserService $userService,
                                ComponentService $componentService)
    {
        $this->processService = $processService;
        $this->userService = $userService;
        $this->componentService = $componentService;
    }

    public function show(Request $request)
    {
        $rules = [
            'componentName' => 'required'
        ];
        $this->validate($request, $rules);
        $componentName = $request->input('componentName');

        $component = $this->componentService->getComponentByName($componentName);

        // 1) first get user from token to check validation
        $user = JWTAuth::parseToken()->authenticate();

        // 2) get all processes belongs to this component
        $processes = $this->processService->getAll($component->id);
        // 2) get accessible processes based on user
        $aclProcesses = $this->userService->getAclResourceByType($user, ResourceType::PROCESS);
        // 3) rebuild $mergedProcesses
        // replace the first array with keys on in first array
        $mergedProcesses = array_replace($processes, array_intersect_key($aclProcesses, $processes));

        // 4) rebuild processes with name key
        $namedProcesses = [];
        foreach($mergedProcesses as $process)
        {
            if (isset($namedProcesses[$process['name']]))
            {
                //error
                return response()->json([
                    'error' => 'Duplicated process name found in this page!',
                ]);
            }
            else
                $namedProcesses[$process['name']] = $process;
        }
        // 5) return processes
        return response()->json([
            'processes' => json_encode($namedProcesses),
        ]);
    }
}
