<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Product extends Model
{
    use ElasticquentTrait;

    /**
     * Product elasticsearch analysis.
     *
     * @var array
     */
    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ],
                'stop_words' => [
                    'type' => 'stop',
                    'stopwords' => '_english_',
                ],
                'autocomplete' => [
                    'type' => 'edge_ngram',
                    'min_gram' => 2,
                    'max_gram' => 20
                ],
            ],
            'analyzer' => [
                'standard' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                        'stop_words',
                        'autocomplete',
                    ],
                ],
            ],
        ],
    ];

    /**
     * Product elasticsearch mapping
     *
     * @var array
     */
    protected $mappingProperties = [
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'desc' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'price' => [
            'type' => 'integer',
        ],
        'quantity' => [
            'type' => 'integer',
        ],
        'category' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'integer'
                ],
                'name' => [
                    'type' => 'string'
                ],
            ]
        ],
        'brand' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'integer'
                ],
                'name' => [
                    'type' => 'string'
                ],
            ]
        ],
        'offer' => [
            'type' => 'boolean',
        ],
        'created_at' => [
            'type' => 'date',
            "index" => "not_analyzed",
            "format" => "yyyy-MM-DD HH:mm:ss"
        ],
        'updated_at' => [
            'type' => 'date',
            "index" => "not_analyzed",
            "format" => "yyyy-MM-DD HH:mm:ss"
        ],
        'images' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'integer'
                ],
                'img' => [
                    'type' => 'text'
                ]
            ]
        ],
    ];

    /**
     * Get the fields that will be indexed in Elasticsearch
     *
     * @return array
     */
    public function getIndexDocumentData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ],
            'offer' => $this->offer,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'images' => $this->getImgMappingArray($this->productImg->toArray()),
        ];
    }

    /**
     * Get images mapping array
     *
     * @param array|null $productImgs
     * @return array
     */
    private function getImgMappingArray(?array $productImgs): array
    {
        $mapping = [];
        foreach ($productImgs as $productImg) {
            $mapping[] = array_intersect_key(
                $productImg,
                $this->mappingProperties['images']['properties']
            );
        }

        return $mapping;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImg()
    {
        return $this->hasMany(ProductImg::class);
    }

    public function customField()
    {
        return $this->belongsToMany(CustomField::class, 'custom_field_products', 'product_id', 'custom_field_id');
    }
}
