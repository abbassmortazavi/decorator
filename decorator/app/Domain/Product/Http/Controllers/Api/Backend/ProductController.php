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
use OpenApi\Annotations as OA;

class ProductController extends BaseApiController
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get All Data Json Or Xml",
     *     @OA\Response(response="200", description="Success")
     * )
     * @throws Exception
     */
    public function index()
    {
        $service = resolve('App\Domain\Product\Services\Backend\ProductService');
        return response()->json($service->index());
    }
}