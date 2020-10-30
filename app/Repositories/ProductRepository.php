<?php

namespace App\Repositories;

use App\Model\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use DB;
use Illuminate\Database\Query\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all product
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * Get single product by id
     *
     * @param int $productId
     * @return Product
     */
    public function find(int $productId)
    {
        return Product::find($productId);
    }

    /**
     * Get product by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Product::where($column, $value)->get();
    }

    /**
     * Get products by cetegory ID
     *
     * @param int $categoryId
     * @return Builder
     */
    public function getProductsByCategoryQuery(int $categoryId): Builder
    {
        return DB::table('products AS p')
            ->addSelect('p.*')
            ->addSelect('b.name AS brandName')
            ->addSelect(
                DB::raw(
                    "(
                    SELECT img
                    FROM product_imgs
                    WHERE product_id  = p.id
                    LIMIT 1) AS img"
                )
            )
            ->join('brands AS b', 'p.brand_id', '=', 'b.id')
            ->where('p.category_id', $categoryId);
    }

    /**
     * Get Query Builder
     *
     * @return Builder
     */
    public function getQueryBuilder(): Builder
    {
        return DB::table('products AS p');
    }

    /**
     * Filter by price
     *
     * @param Builder $qb
     * @param mixed $value
     * @return Builder
     */
    public function addPriceFilter(Builder $qb, $value): Builder
    {
        if (isset($value['min'])) {
            $qb->where('p.price', '>=', $value['min']);
        }

        if (isset($value['max'])) {
            $qb->where('p.price', '<=', $value['max']);
        }
        return $qb;
    }

    /**
     * Filter by brand
     *
     * @param Builder $qb
     * @param mixed $value
     * @return Builder
     */
    public function addBrandFilter(Builder $qb, $value): Builder
    {
        return $qb->where('p.brand_id', $value);
    }

    /**
     * Sort filter
     *
     * @param Builder $qb
     * @param mixed $value
     * @return Builder
     */
    public function addSortByFilter(Builder $qb, $value): Builder
    {
        return $qb->orderBy($value[0], $value[1]);
    }

    /**
     * Add custom field filter
     *
     * @param Builder $qb
     * @param array $customFields
     * @return Builder
     */
    public function addCustomFieldFilter(Builder $qb, array $customFields): Builder
    {
        foreach ($customFields as $key => $value) {
            $qb = $qb->join(
                "custom_field_products AS cfp$key", function ($join) use ($key, $value) {
                    $join->on('p.id', '=', "cfp$key.product_id")
                        ->where("cfp$key.value", '=', $value);
                }
            );
        }

        return $qb;
    }
}