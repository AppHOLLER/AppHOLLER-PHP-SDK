<?php namespace Rainmakerlabs\Holler\Exceptions;

/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/13/15
 * Time: 10:26 AM
 */
class HollerExceptions extends \Exception
{
    protected $response_data;

    protected $api_request;

    protected $parameter_request;

    protected $method_request;

    /**
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->response_data;
    }

    /**
     * @param mixed $response_data
     */
    public function setResponseData($response_data)
    {
        $this->response_data = $response_data;
    }

    /**
     * @return mixed
     */
    public function getApiRequest()
    {
        return $this->api_request;
    }

    /**
     * @param mixed $api_request
     */
    public function setApiRequest($api_request)
    {
        $this->api_request = $api_request;
    }

    /**
     * @return mixed
     */
    public function getParameterRequest()
    {
        return $this->parameter_request;
    }

    /**
     * @param mixed $parameter_request
     */
    public function setParameterRequest($parameter_request)
    {
        $this->parameter_request = $parameter_request;
    }

    /**
     * @return mixed
     */
    public function getMethodRequest()
    {
        return $this->method_request;
    }

    /**
     * @param mixed $method_request
     */
    public function setMethodRequest($method_request)
    {
        $this->method_request = $method_request;
    }



}