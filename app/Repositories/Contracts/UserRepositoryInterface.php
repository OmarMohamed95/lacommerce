<?php

namespace App\Repositories\Contracts;

use App\Model\User;

interface UserRepositoryInterface
{
    /**
     * Get all users
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single user by id
     *
     * @param int $userId
     * @return User
     */
    public function find(int $userId);

    /**
     * Get user by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}