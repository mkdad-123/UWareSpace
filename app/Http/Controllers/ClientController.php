<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Services\MemberService;
use App\Traits\ModelOperationTrait;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ModelOperationTrait;

    public function __construct()
    {
        $this->setmodel(new Client());
    }

    public function store(ClientStoreRequest $request ,MemberService $memberService)
    {
       return $this->storeMember($request ,$memberService);
    }

    public function update($id,ClientUpdateRequest $request ,MemberService $memberService)
    {
        return $this->updateMember($id,$request ,$memberService);
    }


}
