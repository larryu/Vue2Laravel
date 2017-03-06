<?php
namespace App\Models\Services;

use App\Models\Repositories\ComponentRepository;

class ComponentService
{
    protected $componentRepository;

    public function __construct(ComponentRepository $componentRepository)
    {
        $this->componentRepository = $componentRepository;
    }
    public function getAll($pageId)
    {
        return $this->componentRepository->getAll($pageId);
    }
    public function getComponentByName($componentName)
    {
        return $this->componentRepository->getComponentByName($componentName);
    }
}