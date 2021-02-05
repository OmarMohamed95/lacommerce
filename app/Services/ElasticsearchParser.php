<?php

namespace App\Services;

use App\Contracts\ElasticsearchParserInterface;

class ElasticsearchParser implements ElasticsearchParserInterface
{
    /**
     * Parse elasticsearch response hits
     *
     * @param array $hits
     * @return array
     */
    public function parseHits(array $hits): array
    {
        return array_column($hits, '_source');
    }
}