<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;

class ComponentRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\Component';
    }
    public function getComponentByName($componentName)
    {
        return $this->model->where('name', $componentName)->where('active', 1)->first();
    }
    public function getAll($pageId)
    {
        return $this->model->where('active', 1)->where('page_id', $pageId)
            ->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();
    }

}