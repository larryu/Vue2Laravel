<?php

namespace App\Models\Repositories;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{
    public function model() {
        return 'App\Models\Entities\User';
    }
    /**
     * @param $user
     * @return mixed
     */
    public function getRoles($user)
    {
        return $user->roles();
    }

}