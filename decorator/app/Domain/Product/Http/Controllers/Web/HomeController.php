<?php
/**
 * WebController.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from pinarkhodro-v2
 * @version 1.0.0
 * @date 2023/03/26 20:17
 */


namespace App\Domain\Home\Http\Controllers\Web;

use App\Infrastructure\Http\Controllers\Frontend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Application|Factory|View
     */
    public function admin()
    {
        return view('home::backend.index');
    }

}
