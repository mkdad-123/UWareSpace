<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Models\Client;
use App\Services\MemberService;
use App\Traits\ModelOperationTrait;

class ClientController extends Controller
{

    use ModelOperationTrait;

    public function __construct()
    {
        $this->middleware('permission:manage clients|manage external members');

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
