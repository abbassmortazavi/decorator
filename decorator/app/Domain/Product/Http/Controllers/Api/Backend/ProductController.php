<?php
/**
 * ProductController.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from domain-driven
 * @version 1.0.0
 * @date 2023/09/26 20:43
 */


namespace App\Domain\Product\Http\Controllers\Api\Backend;

use App\Infrastructure\Http\Controllers\Backend\BaseApiController;
use Exception;

class ProductController extends BaseApiController
{
    /**
     * @throws Exception
     */
    public function index()
    {
        $service = resolve('App\Domain\Product\Services\Backend\ProductService');
        return response()->json($service->index());
    }
}
