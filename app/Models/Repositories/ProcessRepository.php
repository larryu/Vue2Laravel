<?php

namespace App\Models\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use DB;

class ProcessRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\Process';
    }

    public function getAll($componentId)
    {
        return $this->model->where('active', 1)->where('component_id', $componentId)
            ->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();
    }
}