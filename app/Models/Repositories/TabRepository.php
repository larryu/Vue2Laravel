<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;

class TabRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\Tab';
    }

    public function getAll()
    {
        return $this->model->where('active',1)->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();

    }
}