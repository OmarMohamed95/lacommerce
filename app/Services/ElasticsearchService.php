<?php

namespace App\Services;

class ElasticsearchService
{
    /**
     * Check if the document exists
     *
     * @param Model $model
     * @return bool
     */
    public function isDocumentFound($model)
    {
        try {
            $isDocumentFound = (bool) $model->getIndexedDocument();
        } catch (\Exception $th) {
            $isDocumentFound = false;
        }

        return $isDocumentFound;
    }
}