<?php

namespace App\Models\Services;

use App\Models\Repositories\TabRepository;

class TabService
{
    protected $tabRepository;

    public function __construct(TabRepository $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function getAll()
    {
        return $this->tabRepository->getAll();
    }

}