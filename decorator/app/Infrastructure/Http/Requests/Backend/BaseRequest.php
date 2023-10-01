<?php

namespace App\Infrastructure\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as IlluminateRequest;

abstract class BaseRequest extends FormRequest
{


    protected $formRequest;

    protected $formRequestUser;

    protected $model;


    /**
     * Constructor
     *
     * BaseRequest constructor.
     * @param IlluminateRequest $request
     */
    public function __construct(IlluminateRequest $request)
    {
        $this->formRequest = $request;

        parent::__construct();
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
