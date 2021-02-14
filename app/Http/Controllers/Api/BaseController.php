<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Json response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondJson($data = [], $status = 200, array $headers = [], $options = 0)
    {
        return response()->json($data, $status, $headers, $options);
    }

    /**
     * No content response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNoContent(array $headers = [], $options = 0)
    {
        return response()->json([], 204, $headers, $options);
    }
}
