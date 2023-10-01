<?php
/**
 * XMLOutput.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from decorator
 * @version 1.0.0
 * @date 2023/10/01 16:07
 */


namespace App\Domain\Product\Strategy;

use Symfony\Component\Yaml\Yaml;

class XMLOutput implements OutputStrategy
{
    /**
     * @param object $data
     * @return array
     */
    public function generateOutput(object $data): array
    {
        $fields = Yaml::parseFile(base_path('attributes.yml'));
        $mappedData = [];
        foreach ($data->travelers->Travelerinformation as $item) {
            $item = (array)$item;
            $mappedItem = [];
            foreach ($fields['attributes'] as $key => $value) {
                if (isset($item[$key])) {
                    $mappedItem[$value] = $item[$key];
                }
            }
            $mappedData[] = $mappedItem;
        }
        return $mappedData;
    }
}
