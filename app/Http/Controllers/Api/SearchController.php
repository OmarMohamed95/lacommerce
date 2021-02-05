<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ElasticsearchParserInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Repositories\Contracts\ProductElasticsearchRepositoryInterface;

class SearchController extends Controller
{
    /**
     * @var ElasticsearchParserInterface $elasticsearchParser
     */
    private $elasticsearchParser;
    
    /**
     * @var ProductElasticsearchRepositoryInterface $ProductElasticsearchRepository
     */
    private $ProductElasticsearchRepository;

    public function __construct(
        ElasticsearchParserInterface $elasticsearchParser,
        ProductElasticsearchRepositoryInterface $ProductElasticsearchRepository
    ) {
        $this->elasticsearchParser = $elasticsearchParser;
        $this->ProductElasticsearchRepository = $ProductElasticsearchRepository;
    }

    /**
     * Search action
     *
     * @return void
     */
    public function search(Request $request)
    {
        $query = $request->q;
        if (!$query) {
            return response()->json([], 204);
        }

        $products = $this->ProductElasticsearchRepository->search($query);
        $hits = $products->getHits()['hits'];
        $response = $this->elasticsearchParser->parseHits($hits);
        return response()->json([$response], 200);
    }
}
