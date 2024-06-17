<?php

namespace App\ResponseManger;

class OperationResult
{
    public $message;

    public $data;

    public $status;

    public function __construct($message,$data = null,$status = 200)
    {
        $this->data = $data;
        $this->message = $message;
        $this->status = $status;
    }

}
