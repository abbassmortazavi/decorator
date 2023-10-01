<?php

namespace App\Infrastructure\Http\Responses\Common;

use App\Infrastructure\Http\Traits\Request;
use App\Infrastructure\Http\Traits\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class BaseResponse
{
    use View, Request;
    /**
     * @var store the response data.
     */
    protected $data = null;

    /**
     * @var BaseResponse message for the response.
     */
    protected $message = null;

    /**
     * @var BaseResponse status for the response.
     */
    protected $status = null;

    /**
     * @var BaseResponse code for the response.
     */
    protected $code = null;

    /**
     * @var  Url for the redirect response.
     */
    protected $url = null;

    /**
     * Return the type of response for the current request.
     *
     * @return  string
     */
    protected function getType()
    {

        if ($this->type) {
            return $this->type;
        }

        if (request()->wantsJson()) {
            return 'json';
        }

        if (request()->ajax()) {
            return 'ajax';
        }

        return 'http';

    }

    /**
     * Return json array for  json response.
     *
     * @return JsonResponse
     */
    protected function json()
    {
        return response()->json($this->getData(), 200);
    }

    /**
     * Return view for the ajax response.
     *
     * @return Response
     */
    protected function ajax()
    {
        //Form::populate($this->getFormData());
        return response()->view($this->getView(), $this->getData());
    }

    /**
     * Return  whole page for the http request.
     *
     * @return theme page
     *
     */
    protected function http()
    {
        //Form::populate($this->getFormData());
        $this->theme->prependTitle($this->getTitle());

        return $this->theme->of($this->getView(), $this->getData())->render();
    }

    /**
     * Return  whole page for the http request.
     *
     * @return JsonResponse
     */
    public function redirect()
    {

        if ($this->typeIs('json')) {
            return response()->json([
                'message' => $this->getMessage(),
                'code'    => $this->getCode(),
                'status'  => $this->getStatus(),
                'url'     => $this->getUrl(),
            ], $this->getStatusCode());
        }

        if ($this->typeIs('ajax')) {
            return response()->json([
                'message' => $this->getMessage(),
                'code'    => $this->getCode(),
                'status'  => $this->getStatus(),
                'url'     => $this->getUrl(),
            ], $this->getStatusCode());
        }

        return redirect($this->url)
            ->withMessage($this->getMessage())
            ->withStatus($this->getStatus())
            ->withCode($this->getCode());
    }

    /**
     * Return the output for the current response.
     *
     * @return Theme|JsonResponse|Response
     */
    public function output()
    {

        if ($this->typeIs('json')) {
            return $this->json();
        }

        if ($this->typeIs('ajax')) {
            return $this->ajax();
        }

        return $this->http();
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return self
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return self
     */
    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status == 'success' ? 201 : 400;
    }

    /**
     * @param mixed $code
     *
     * @return self
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  View for the request $url
     *
     * @return self
     */
    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param store the response type $this->getData()
     *
     * @return self
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * get the response data $data
     *
     * @return array|store
     */
    public function getData()
    {
        return is_array($this->data) ? $this->data : [];
    }

    /**
     * @paramg get the response data $data
     *
     * @return array|mixed
     */
    public function getFormData()
    {

        if (is_array($this->data)) {
            return current($this->data);
        }

        return [];
    }

    /**
     * Return auth guard for the current route.
     *
     * @return mixed
     */
    protected function getGuard()
    {
        return get_guard();//getenv('guard');
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $callable = preg_split('|[A-Z]|', $method);

        if (in_array($callable[0], ['set', 'prepend', 'append', 'has', 'get'])) {
            $value = lcfirst(preg_replace('|^' . $callable[0] . '|', '', $method));
            array_unshift($parameters, $value);
            call_user_func_array([$this->theme, $callable[0]], $parameters);
        }
        return $this;
    }

}
