<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

class PageRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Entities\Page';
    }

    public function getPageByName($pageName)
    {
        return $this->model->where('name', $pageName)->where('active', 1)->first();
    }

}