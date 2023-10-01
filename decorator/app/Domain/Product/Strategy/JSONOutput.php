<?php
/**
 * JSONOutput.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from decorator
 * @version 1.0.0
 * @date 2023/10/01 16:06
 */


namespace App\Domain\Product\Strategy;

use Symfony\Component\Yaml\Yaml;

class JSONOutput implements OutputStrategy
{
    /**
     * @param object $data
     * @return array
     */
    public function generateOutput(object $data): array
    {
        $fields = Yaml::parseFile(base_path('attributes.yml'));

        $jsonData = $data->json()['products'];

        $mappedData = [];
        foreach ($jsonData as $item) {
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
