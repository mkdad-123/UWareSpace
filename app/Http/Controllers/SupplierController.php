<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\SupplierStoreRequest;
use App\Http\Requests\Supplier\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Services\MemberService;
use App\Traits\ModelOperationTrait;

class SupplierController extends Controller
{

    use ModelOperationTrait;

    public function __construct()
    {
        $this->middleware('permission:manage suppliers|manage external members');

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
