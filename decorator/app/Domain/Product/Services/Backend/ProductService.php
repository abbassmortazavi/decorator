<?php

namespace App\Domain\Product\Services\Backend;


use App\Domain\Product\Strategy\ExportDataStrategy;
use Exception;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;


class ProductService
{
    /**
     * @throws Exception
     */
    public function index(): array
    {
        $jsonData = Http::get("https://dummyjson.com/products");
        $xmlData = new SimpleXMLElement("http://restapi.adequateshop.com/api/Traveler", null, true);

        $outPutContext = new ExportDataStrategy();
        return $outPutContext->generateOutput("json", $jsonData);

    }

}
