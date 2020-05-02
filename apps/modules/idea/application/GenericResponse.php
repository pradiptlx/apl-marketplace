<?php

namespace Idy\Idea\Application;

class GenericResponse
{
    protected $data;
    protected $message;
    protected $error;
    protected $code;

    /**
     * GenericResponse constructor.
     * @param $data
     * @param $message
     * @param int $code
     * @param $error
     */
    public function __construct($data, $message, $code = 200, $error = null)
    {
        $this->data = $data;
        $this->message = $message;
        $this->code = $code;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
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
    public function setData($data): void
    {
        $this->data = $data;
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
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }


}