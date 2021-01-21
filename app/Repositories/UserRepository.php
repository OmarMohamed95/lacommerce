<?php

namespace App\Repositories;

use App\Model\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return User::all();
    }

    /**
     * Get single user by id
     *
     * @param int $userId
     * @return User
     */
    public function find(int $userId)
    {
        return User::find($userId);
    }

    /**
     * Get user by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return User::where($column, $value)->get();
    }
}