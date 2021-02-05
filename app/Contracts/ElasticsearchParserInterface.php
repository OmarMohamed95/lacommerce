<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ElasticsearchParserInterface
{
    /**
     * Parse elasticsearch response hits
     *
     * @param array $hits
     * @return array
     */
    public function parseHits(array $hits): array;
}