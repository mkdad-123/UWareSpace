<?php

namespace App\Traits;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Services\PhoneService;
use Illuminate\Database\Eloquent\Model;
use Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

trait ModelOperationTrait
{
    protected $model;
    public function setModel($model)
    {
        $this->model = $model ;
    }
    public function show(){
        $members = $this->model->where('admin_id',auth('admin')->user()->id)->get();
        if ($members){
            return response()->json([
                'data' =>$members,
                'message'=> 'members is showed successfuly',
                'sataus'=>200
            ]);
            }
        else {
            return response()->json([
                'data' =>[],
                'message'=> 'member show is failed',
                'sataus'=>401
            ]);        }
    }
    public function showId (){
        $member = $this->model->find(Request::input('id'));
        if($member!=null){
        if ($member->admin_id == auth('admin')->user()->id){
            return response()->json([
                'data' =>$member,
                'message'=> 'members is showed successfuly',
                'sataus'=>200
            ]);}
            else{
                return response()->json([
                    'data' =>[],
                    'message'=> 'member show is failed',
                    'sataus'=>401]);
            }
        }
            else {
                return response()->json([
                    'data' =>[],
                    'message'=> 'member show is failed',
                    'sataus'=>401]);
                }
            }

    public function store (ClientStoreRequest $clientRequest){
            $member = $this->model->create([
            'name'            =>$clientRequest->name,
            'location'        =>$clientRequest->location,
            'email'           =>$clientRequest->email,
            'admin_id'        => auth('admin')->user()->id,
        ]);
        $member = PhoneService::storePhones($member , $clientRequest->input('phones'));
        if($member){
                return response()->json([
                    'data' =>$member,
                    'message'=> 'member is added successfuly',
                    'sataus'=>200
                ]);
                }
                return response()->json([
                    'data' =>[],
                    'message'=> 'member add is failed',
                    'sataus'=>401
                ]);
            }

    public function update (ClientUpdateRequest $clientRequest ){
            $member = $this->model->find( $clientRequest->input('id'));
            if ($clientRequest->phones) {
                (new PhoneService())->updatePhones($clientRequest->phones, $member);
            }
            if($member !=null && $member->admin_id == auth('admin')->user()->id){
            $member ->update([
            'name'     =>$clientRequest->name,
            'location' =>$clientRequest->location ,
            'email'    =>$clientRequest->email,
        ]);
            return response()->json([
                'data' =>$member,
                'message'=> 'member is updated successfuly',
                'sataus'=>200
            ]);
                }
                return response()->json([
                    'data' =>[],
                    'message'=> 'member update is failed',
                    'sataus'=>401
                ]);
            }

    public function delete(){
        $member = $this->model->find(Request::input('id'));
        if($member!= null && $member->admin_id == auth('admin')->user()->id){
        $member->delete();
            return response()->json([
                'data' =>$member,
                'message'=> 'member is deleted successfuly',
                'sataus'=>200
            ]);
        }
        else{
            return response()->json([
                'data' =>[],
                'message'=> 'member deleted is failed or the member has been already not exist',
                'sataus'=>401
            ]);        }
    }
    public function sort (){
        $column = Request::input('sort_column');
        $direction = Request::input('sort_direction');
        $members = $this->model::where('admin_id',auth('admin')->user()->id)->orderBy($column, $direction)->get();
        if($members){
            return response()->json([
                'data' =>$members,
                'message'=> 'member is deleted successfuly',
                'sataus'=>200
            ]);
        }
        else{
            return response()->json([
                'data' =>[],
                'message'=> 'member deleted is failed or the member has been already not exist',
                'sataus'=>401
            ]);        }
        }
    }



