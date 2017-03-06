<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 3/5/17
 * Time: 12:15 AM
 */

namespace App\Models\Services;

use App\Models\Repositories\ProcessRepository;

class ProcessService
{
    protected $processRepository;

    public function __construct(ProcessRepository $processRepository)
    {
        $this->processRepository = $processRepository;
    }

    public function getAll($componentId)
    {
        return $this->processRepository->getAll($componentId);
    }
}