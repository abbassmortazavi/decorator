<?php

namespace App\Domain\Product\Services\Backend;


use App\Domain\Product\Enums\OutputExport;
use Exception;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;


class ProductService
{
    /**
     * @throws Exception
     */
    public function products(): array
    {
        $jsonData = Http::get("https://dummyjson.com/products");
        $xmlData = new SimpleXMLElement("http://restapi.adequateshop.com/api/Traveler", null, true);
        $export = resolve('App\Domain\Product\Strategy\ExportDataStrategy');
        return $export->generateOutput(OutputExport::JSON->value, $jsonData);
    }

}
