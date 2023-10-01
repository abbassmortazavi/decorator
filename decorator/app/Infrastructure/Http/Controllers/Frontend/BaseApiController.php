<?php

namespace App\Infrastructure\Http\Controllers\Frontend;

use App\Infrastructure\Traits\Jsons\JsonExceptionHandlerTrait;
use App\Infrastructure\Traits\Jsons\JsonResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, JsonExceptionHandlerTrait, JsonResponseTrait;


    protected $service;

    protected $apiAuthMiddleware = 'auth:client:api';

    /**
     * Initialize  BaseController constructor.
     */
    public function __construct()
    {
        $this->apiAuthMiddleware = config('base.auth_middleware.client'); //auth:client:api
    }

}
