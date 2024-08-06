<?php

namespace App\Http\Controllers\Subscription;
use Stripe\Plan;
use App\Models\plan as ModelsPlan;
use Exception;
use Stripe\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function MakePlan(Request $request)
    {
        try{
        $amount = ($request->amount * 100);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $Plan = plan::create([
                "amount"         => $amount,
                'currency'       => $request->currency,
                'product'       => [
                    'name'           => $request->name
                ],
                'interval_count' => $request->interval_count,
                'interval' => $request->billing_period,

            ]);
            if ($Plan) {
                $plan = ModelsPlan::create([
                    'price'           => $Plan->amount,
                    'currency'        => $Plan->currency,
                    'name'            => $request->name,
                    'interval_count'  => $Plan->interval_count,
                    'billing_method'  => $Plan->interval,
                    'discription'     => $request->discription,
                    'plan_id'         => $Plan->id,
                    'num_of_employees'=>$request->employees_number,
                ]);
            }
            if ($plan) {
                return $this->response($plan , "the plan is created ",200);
            } else {
                return $this->response([],"the plan is not created" , 401);
            }}
            catch(Exception $e){
                return response()->json(
                    ['message' => $e->getMessage()]
                );
            }
    }
    public function ShowPlans()
    {
        $plans = ModelsPlan::select('name', 'price' , 'discription' ,'billing_method', 'interval_count' ,'currency')->get();
        if ($plans) {
            return $this->response($plans , "show successs ",200);
        } else {
            return $this->response([],"show failed" , 401);
        }
    }
    public function PickePlan(Request $request)
    {
        $Plan = ModelsPlan::where('plan_id', $request->plan_id)->first();
        $admin_intent = auth('admin')->user()->createSetupIntent();
        if (!$Plan) {
                return $this->response([] , "picking a plan is failed",401);
            } else {
                return $this->response([$Plan ,$admin_intent],"picking success" , 200);
            }
    }
    public function processPlan(Request $request)
    {
        try {
        $admin = auth("admin")->user();
        $admin->createOrGetStripeCustomer();
        $paymentMethod = null;
        $paymentMethod = $request->paymentMethod;
        if ($paymentMethod != null) {
            $paymentMethod = $admin->addPaymentMethod($paymentMethod);
        }
        $plan = $request->plan_id;
            $done = $admin->newSubscription('default', $plan)->create();
            if ($done) {
                return $this->response($done ,"subscription success" ,200);
            }
            else{
                return $this->response([],"subscription failed" ,401);
            }
        } catch (Exception $e) {
            return response()->json(
                ['message' => $e->getMessage()]
            );
        }
    }
}
