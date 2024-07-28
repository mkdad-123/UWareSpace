<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Traits\ModelOperationTrait;
class ClientController extends Controller
{
    use ModelOperationTrait;

    public function __construct()
    {
        $this->setmodel(new Client());

    }

}


