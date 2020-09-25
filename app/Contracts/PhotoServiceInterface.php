<?php

namespace App\Contracts;

interface PhotoServiceInterface
{
    /**
     * Store photo in disk storage
     *
     * @return array
     *
     * @throws Exception
     */
    public function store(): array;

    /**
     * Get store path
     *
     * @return string
     */
    public function getStorePath(): string;

    /**
     * Set store path
     *
     * @param string $path 
     * 
     * @return self
     */
    public function setStorePath(string $path);
}