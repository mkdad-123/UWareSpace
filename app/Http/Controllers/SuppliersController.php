<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClientStoreRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Traits\ModelOperationTrait;

class SuppliersController extends Controller
{
    use ModelOperationTrait;

    public function __construct()
    {
        $this->setmodel(new Supplier());

    }}
