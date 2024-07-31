<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Services\MemberService;
use App\Traits\ModelOperationTrait;

class SupplierController extends Controller
{
    use ModelOperationTrait;

    public function __construct()
    {
        $this->setmodel(new Supplier());
    }

    public function store(SupplierStoreRequest $request ,MemberService $memberService)
    {
        return $this->storeMember($request ,$memberService);
    }

    public function update($id,SupplierUpdateRequest $request ,MemberService $memberService)
    {
        return $this->updateMember($id,$request ,$memberService);
    }
}
