<?php

namespace App\Traits;

use App\Http\Resources\MemberResource;
use App\Models\Client;
use Request;

trait ModelOperationTrait
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model ;
    }

    public function showAll()
    {
        $admin = auth('admin')->user() ?:auth('employee')->user()->admin;

        $members = $this->model->where('admin_id',$admin->id)->get();

        if ($members){
            return $this->response(MemberResource::collection($members), 'members is showed successfully');
        }
        else {
            return $this->response(response(), 'members are not found', 404);
        }
    }

    public function show($id)
    {

        $member = $this->model->find($id);

        if($member!=null)
        {
            $admin = auth('admin')->user() ?:auth('employee')->user()->admin;

            if ($member->admin_id == $admin->id)
            {
                if($this->model instanceof Client)
                {
                    return $this->response(new MemberResource($member->load('phones' , 'sellOrders.order.orderItems.item')),
                        'members is showed successfully');
                } else {
                    return $this->response(new MemberResource($member->load('phones' , 'purchaseOrders.order.orderItems.item')),
                        'members is showed successfully');
                }
            }
            else {
                return $this->response($member, 'member show is failed',403);
            }
        }
        else {
            return $this->response($member, 'member is not found', 404);
        }
    }

    public function storeMember($request , $memberService)
    {
        if($this->model instanceof Client)
        {
            $result = $memberService->storeClient(
                $this->model,
                $request->except(['location' , 'phones']) ,
                $request->input('location'),
                $request->input('phones')
            );
        } else {

            $result = $memberService->storeSupplier(
                $this->model,
                $request->except('phones') ,
                $request->input('phones')
            );
        }


        if ( $result->status == 201){
            return $this->response(
                new MemberResource($result->data),
                $result->message,
                $result->status,
            );
        }
        return  $this->response(
            $result->data,
            $result->message,
            $result->status,
        );
    }

    public function updateMember($id ,  $request ,  $memberService)
    {

        $member = $this->model->find($id);

        $admin = auth('admin')->user() ?:auth('employee')->user();

        if($member->admin_id == $admin->id) {

            if ($this->model instanceof Client) {
                $result = $memberService->updateClient(
                    $member,
                    $request->except(['location', 'phones']),
                    $request->input('location'),
                    $request->input('phones')
                );

            } else {

                $result = $memberService->updateSupplier(
                    $member,
                    $request->except('phones'),
                    $request->input('phones')
                );
            }

            if ($result->status == 200) {
                return $this->response(
                    new MemberResource($result->data),
                    $result->message,
                    $result->status,
                );
            }
            return $this->response(
                $result->data,
                $result->message,
                $result->status,
            );
        }
            return $this->response(response(), 'member show is failed',403);

    }

    public function delete($id){

        $member = $this->model->find($id);

        $admin = auth('admin')->user() ?:auth('employee')->user();

        if($member!= null && $member->admin_id == $admin->id){

            $member->load('phones')->delete();

            $member->delete();

            return $this->response(response(),'member is deleted successfully');
        }
        else{
            return $this->response(response(),'member is not found' , 404);

        }
    }

    public function sort (){

        $column = Request::input('sort_column');

        $direction = Request::input('sort_direction');

        $admin = auth('admin')->user() ?:auth('employee')->user();

        $members = $this->model::where('admin_id',$admin->id)->orderBy($column, $direction)->get();

        if($members){
            return $this->response(response(),'member has been sorted successfully');
        }
        else{
            return $this->response(response(),'member is not found' , 404);
        }
    }
}
