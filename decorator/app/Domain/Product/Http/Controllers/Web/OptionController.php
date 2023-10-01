<?php

namespace App\Domain\Home\Http\Controllers\Web;

use App\Domain\Courses\Models\Course;
use App\Domain\Financial\Enums\GatewayStatusEnum;
use App\Domain\Financial\Models\Order;
use App\Domain\Financial\Models\Payment;
use App\Domain\Home\Enums\OutputExport;
use App\Domain\Home\Models\Product;
use App\Domain\Home\Services\Backend\ProductService;
use App\Domain\Posts\Models\PostData;
use App\Domain\TechnicalTeam\Models\Team;
use App\Domain\Users\Models\User;
use App\Infrastructure\Enums\StatusEnum;
use App\Infrastructure\Http\Controllers\Frontend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class OptionController extends BaseController
{
    public function __construct(ProductService $optionService)
    {
        parent::__construct();
        $this->service = $optionService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $options = $this->service->index();
        return view('home::backend.option.index', compact('options'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('home::backend.option.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->service->store($request->only('priority','position', 'middle_content_title','middle_content','footer_content'),$request->file('image'));
        return redirect()->route('backend.option.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $aboutUs = $this->service->show($id);
        return view('home::backend.option.edit', compact('aboutUs'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(Request $request, $id)
    {
        $attr = $request->only('position', 'image', 'middle_content_title','middle_content','footer_content');
        $this->service->update($id, $attr);
        return redirect()->route('backend.option.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->service->destroy($id, 'normal');
        return redirect()->route('backend.option.index');
    }
}
