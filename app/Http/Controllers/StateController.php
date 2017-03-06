<?php

namespace App\Http\Controllers;

use App\Models\Services\StateService;
use App\Models\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class StateController extends Controller
{
    protected $stateService;
    protected $userService;

    public function __construct(StateService $stateService, UserService $userService)
    {
        $this->stateService = $stateService;
        $this->userService = $userService;
    }
    /**
     * @param Request $request
     * @return array|null
     */
    public function getStateNodes(Request $request)
    {
        try {
            // 1) first get user from token to check validation
            $user = JWTAuth::parseToken()->authenticate();
            // 2) get all states
            $stateNodes= $this->stateService->getAllStateNodes();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'stateNodes' => $stateNodes,
        ]);
    }
    public function updateState(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);

            $user = JWTAuth::parseToken()->authenticate();

            $state = $this->stateService->update($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('state'));
    }
    public function addState(Request $request)
    {
        $rules = [
            'name'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $state = $this->stateService->add($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(compact('state'));
    }
    public function deleteState(Request $request)
    {
        $rules = [
            'id'  =>  'required',
        ];
        try {
            $this->validate($request, $rules);
            $user = JWTAuth::parseToken()->authenticate();
            $state = $this->stateService->delete($request);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('state'));
    }

}
