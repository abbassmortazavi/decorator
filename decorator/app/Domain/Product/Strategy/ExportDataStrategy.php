<?php
/**
 * ExportDataStrategy.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from decorator
 * @version 1.0.0
 * @date 2023/10/01 16:19
 */


namespace App\Domain\Product\Strategy;

use App\Domain\Product\Enums\OutputExport;
use Exception;

class ExportDataStrategy
{
    /**
     * @param string $type
     * @param object $data
     * @return array
     * @throws Exception
     */
    public function generateOutput(string $type, object $data): array
    {
        $output = $this->defineExportData($type);
        return $output->generateOutput($data);
    }

    /**
     * @param string $type
     * @return XMLOutput|JSONOutput|string
     * @throws Exception
     */
    private function defineExportData(string $type): XMLOutput|JSONOutput|string
    {
        return match ($type) {
            OutputExport::XML->value => new XMLOutput(),
            OutputExport::JSON->value => new JSONOutput(),
            default => throw new Exception('Not Found Export Type!'),
        };
    }
}
