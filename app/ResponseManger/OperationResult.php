<?php

namespace App\ResponseManger;

class OperationResult
{
    public $message;

    public $data;

    public function __construct($data,$message)
    {
        $this->data = $data;
        $this->message = $message;
    }

}
