<?php

namespace App\Infrastructure\Http\Traits;

trait Request
{
    /**
     * @var store the response type.
     */
    protected $type = null;


    /**
     * Return json array for  json response.
     *
     * @return json string
     *
     */
    public function type($type)
    {
        $this->type = in_array($type, ['json', 'ajax', 'http']) ? $type : null;
    }

    /**
     * Return bool response.
     *
     * @param $type
     * @return bool
     */
    public function typeIs($type)
    {
        return $this->getType() == $type;
    }

}
