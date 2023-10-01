<?php
/**
 * OutputStrategy.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from decorator
 * @version 1.0.0
 * @date 2023/10/01 16:07
 */

namespace App\Domain\Product\Strategy;

interface OutputStrategy
{
    /**
     * @param object $data
     * @return mixed
     */
    public function generateOutput(object $data): mixed;
}
