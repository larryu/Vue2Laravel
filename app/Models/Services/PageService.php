<?php

namespace App\Models\Services;

use App\Models\Repositories\PageRepository;

class PageService
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPageByName($pageName)
    {
        return $this->pageRepository->getPageByName($pageName);
    }
}