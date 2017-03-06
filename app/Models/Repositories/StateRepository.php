<?php

namespace App\Models\Repositories;

use App\Models\Entities\State;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;
class StateRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\State';
    }
    public function getAllStateNodes()
    {
        return $this->model->where('active',1)->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();
    }
    public function add($request)
    {
        $state =  new State();
        $state->name = $request->input('name');
        $state->comment = $request->input('comment');
        $state->save();
        return $state;
    }
    public function save($request)
    {
        $state =  $this->model->findOrFail($request->input('id'));
        $state->name = $request->input('name');
        $state->comment = $request->input('comment');
        $state->save();
        return $state;
    }
    public function delete($request)
    {
        $state =  $this->model->findOrFail($request->input('id'));

        // 1) check whether this state has related locations
        $locations = $this->findLocations($state);
        if (count($locations) > 0)
        {
            throw new \Exception('You Cannot delete this state because it has related locations.');
        }
        $state->active = 0;
        $state->save();
        return $state;
    }
    public function findLocations(State $state)
    {
        return $state->locations;
    }
}
