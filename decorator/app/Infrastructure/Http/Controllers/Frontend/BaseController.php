<?php

namespace App\Infrastructure\Http\Controllers\Frontend;

use App\Infrastructure\Http\Responses\Frontend\PublicResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $response;

    protected $service;

    /**
     * Initialize  BaseController constructor.
     */
    public function __construct()
    {
        $this->response = app(PublicResponse::class);
    }

    /**
     * Show dashboard for each user.
     *
     * @return Response
     */
    public function home()
    {
        return $this->response->title('Dashboard')
            ->view('home')
            ->output();
    }
}
