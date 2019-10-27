<?php

namespace App\Http\Controllers\Core;

class Response
{


    public $status;
    public $message;
    public $type;
    public $data;
    public $httpStatusCode;

    public function __construct($status, $message, $type, $data,$statusCode=200){
        $this->setStatus($status);
        $this->setMessage($message);
        $this->setType($type);
        $this->setData($data);
        $this->setHttpStatusCode($statusCode);

    }

    // getters and setters

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    // custom functions
    public static function getNotExistMessage($message, $data, $statusCode=404){
        return new self(false, $message, 'error', $data,$statusCode);
    }

    public  static function getCustomerResponse($message,$data,$statusCode)
    {
        return new self(false, $message, 'error', $data,$statusCode);
    }

    public static function getErrorMessage($message, $data, $statusCode=200){
        return new self(false, $message, 'error', $data,$statusCode);
    }

    public static function getSuccessMessage($message, $data, $statusCode=200){
        return new self(true, $message, 'success', $data,$statusCode);
    }

    public static function getInfoMessage($message, $data, $statusCode=200){
        return new self(true, $message, 'info', $data,$statusCode);
    }

    public static function getWarningMessage($message, $data, $statusCode=200){
        return new self(false, $message, 'warning', $data,$statusCode);
    }

    /**
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @param mixed $httpStatusCode
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }




}
