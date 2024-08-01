<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Phone;
use App\ResponseManger\OperationResult;
use App\Services\PhoneService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AdminRegisterService{

    protected $model;

    protected OperationResult $result;

    public function __construct()
    {
        $this->model = new Admin();
    }

    protected function storeLogo($logo , $data)
    {
        $logoName = time().$logo->getClientOriginalName();

        $logo->storeAs('logos',$logoName,'public');

        $data['logo'] = 'logos/'.$logoName;

        return $data;
    }

    protected function store($data)
    {
        $user = $this->model->create($data);

        return $user;
    }


    protected function sendEmail($user)
    {
        event(new Registered($user));

        //Mail::to($user->email)->send(new SendEmailVerification($user->code,$user->name));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $phones = json_decode($request->input('phones'),true);

            $data = $request->except('phones');

            if ($request->hasFile('logo'))
            {
                $data = $this->storeLogo($request->file('logo') , $data);
            }

            $user = $this->store($data);

            $user = PhoneService::storePhones($user , $phones);

            $this->sendEmail($user);

            DB::commit();

            $this->result = new OperationResult('your account has been created,please check your email',response(),201);

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }
        return $this->result;
    }


}
