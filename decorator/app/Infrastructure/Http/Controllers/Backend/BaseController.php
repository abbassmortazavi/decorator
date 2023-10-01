<?php

namespace App\Infrastructure\Http\Controllers\Backend;

use App\Infrastructure\Http\Responses\Backend\ResourceResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
//use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use App\Package\Theme\Traits\ThemeAndViewsTrait;
use App\Domain\Users\Traits\Auth\RoutesAndGuardsTrait;
use App\Domain\Users\Traits\Auth\UserPagesTrait;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Application|mixed
     */
    public $response;

    protected $validator;

    protected $service;

    /**
     * Initialize  BaseController constructor.
     */
    public function __construct()
    {
        $this->response = app(ResourceResponse::class);

        // Only authenticated users may enter...
       // $this->middleware(['auth', 'verify'])->except(['login', 'logout', 'verify', 'locked', 'sendVerification']);

    }

    /**
     * Show dashboard for each user.
     *
     * @return Response
     */
    public function home(): Response
    {
        return $this->response->title('Dashboard')
            ->view('home')
            ->output();
    }
}
