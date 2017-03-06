<?php

namespace App\Models\Services;

use App\Models\Repositories\StateRepository;

class StateService
{
    protected $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }
    public function getAllStateNodes()
    {
        return $this->stateRepository->getAllStateNodes();
    }
    public function update($request)
    {
        return $this->stateRepository->save($request);
    }
    public function add($request)
    {
        return $this->stateRepository->add($request);
    }
    public function delete($request)
    {
        return $this->stateRepository->delete($request);
    }
}