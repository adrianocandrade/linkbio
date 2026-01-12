<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Plan;
use App\Payments;
use Carbon\Carbon;
use App\Events\PlanEmails;

class PlanController extends Controller{
    public function purchase($id){
        // Check & get plan
        $plan = $this->checkPlan($id);

        // Check if invoice is enabled or not
        $hasInvoice = settings('invoice.enable');

        // Array without error's
        $array = function($array, $key = null){
            app('config')->set('array-temp', $array);
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('array-temp'. $key);
        };
        // Get active payment method's
        $payment = new Payments;
        $payments = $payment->getInstalledMethods();

        $prices = [];
        $prices['monthly'] = $array($plan->price, 'monthly');
        $prices['annually'] = $array($plan->price, 'annually');

        $view = view('mix::plan.index', ['plan' => $plan, 'prices' => $prices, 'hasInvoice' => $hasInvoice, 'payments' => $payments, 'array' => $array]);

        // Switch Plan Types
        switch ($plan->price_type) {
            case 'free':
                $view = view('mix::plan.types.free', ['plan' => $plan]);
            break;

            case 'trial':
                $view = view('mix::plan.types.trial', ['plan' => $plan]);
            break;

            case 'paid':
                $view = $view;
            break;
        }

        // Return view
        return $view;
    }



    // Check Plan if exists
    private function checkPlan($id){
        $plan = Plan::where('id', $id)->where('status', 1)->first();
        if ($plan) {
            return $plan;
        }

        abort(404);
    }

    public function payment($id, Request $request){
        // Captcha here
        \SandyCaptcha::validator($request);
        // Check & get plan
        $plan = $this->checkPlan($id);
        $request->validate([
            'duration' => 'required',
            'gateway'   => 'required'
        ]);

        if (!settings("payment_$request->gateway.status")) {
            return redirect()->route('user-mix-purchase-plan', $plan->id)->with('error', __('Payment method not active. Contact support or try another payment method.'));
        }
        // Payment
        $payment = new Payments();
        // SxRef
        $sxref = md5(microtime());

        // Prices
        $price = ao($plan->price, $request->duration);
        // Keys
        $keys = settings("payment_$request->gateway");

        //
        $callback = route('user-mix-activate-plan', ['id' => $plan->id, 'sxref' => $sxref]);

        $meta = [
            'user' => $this->user->id,
            'plan' => $plan->id,
            'plan_name' => $plan->name,
            'duration' => $request->duration,
            'duration_price' => ao($plan->price, $request->duration),
            'title' => __('Payment of :plan', ['plan' => $plan->name]),
        ];

        $data = [
            'method' => $request->gateway,
            'price' => $price,
            'email' => $this->user->email,
            'callback' => $callback,
            'currency' => settings('payment.currency')
        ];

        $create = $payment->create($sxref, $data, $keys, $meta = $meta);

        // Return the gateway
        return $create;
    }

    // Invoice

    public function invoice($id, Request $request){
        // Check & get plan
        $plan = $this->checkPlan($id);

        // Get invoice field's
        $invoice = getOtherResourceFile('invoiceField');

        // 
        $gateway = $request->get('gateway');
        $duration = $request->get('duration');

        if (!in_array($duration, ['monthly', 'annually'])) {
            abort(404);
        }

        // Check if invoice is enabled
        if (!settings('invoice.enable')) {
            abort(404);
        }

        return view('mix::plan.invoice', ['plan' => $plan, 'invoiceField' => $invoice, 'gateway' => $gateway, 'duration' => $duration]);
    }

    public function activateFree($id){
        // Check & get plan
        $plan = $this->checkPlan($id);

        //
        $activate = ActivatePlan($this->user->id, $plan->id, null);
        if (!ao($activate, 'status')) {
            return fancy_error(__('Dev Error'), ao($activate, 'response'));
        }
        // Return back
        return redirect()->route('user-mix')->with('success', __('Plan Activated Successfully'));
    }

    public function activateTrial($id){
        // Check & get plan
        $plan = $this->checkPlan($id);
        if (\App\Models\PlansHistory::where('user_id', $this->user->id)->where('plan_id', $plan->id)->first()) {
            return back()->with('info', __('Trial already taken.'));
        }

        // Plan Days 
        $days = ao($plan->price, 'trial_duration');

        $duration_time = Carbon::now(settings('others.timezone'))->addDays($days);

        //
        $activate = ActivatePlan($this->user->id, $plan->id, $duration_time);

        if (!ao($activate, 'status')) {
            return fancy_error(__('Dev Error'), ao($activate, 'response'));
        }
        // Return back
        return redirect()->route('user-mix')->with('success', __('Plan Activated Successfully'));
    }

    // Activate user plan
    public function activate($id, $sxref){
        // GET SPV FROM DB
        if ($payment = Payments::is_paid($sxref)) {
            // Get Duration DATE
            $duration = ao($payment->meta, 'duration');
            $duration_time = Carbon::now(settings('others.timezone'));
            switch ($duration) {
                case 'annually':
                    $duration_time->addMonths(12);
                break;
                case 'monthly':
                    $duration_time->addMonths(1);
                break;
            }

            // Plan
            $plan = ao($payment->meta, 'plan');
            $user_id = ao($payment->meta, 'user');


            // Activate
            $activate = ActivatePlan($this->user->id, $plan, $duration_time);

            if (!ao($activate, 'status')) {
                return fancy_error(__('Dev Error'), ao($activate, 'response'));
            }

            $paymentArray = [
                'user'          => $user_id,
                'name'          => user('name', $user_id),
                'plan'          => $plan,
                'plan_name'     => GetPlan('name', $plan),
                'email'         => user('email', $user_id),
                'ref'           => \Str::random(5),
                'currency'      => $payment->currency,
                'duration'      => $duration,
                'price'         => $payment->price,
                'gateway'       => $payment->method,
                'created_at'    => \Carbon\Carbon::now(settings('others.timezone'))
            ];

            \App\Models\PlanPayment::insert($paymentArray);


            $updatePAYMENT = \App\Models\PaymentsSpv::find($payment->id);
            $meta = $updatePAYMENT->meta;
            $meta['plan'] = null;
            $updatePAYMENT->meta = $meta;
            $updatePAYMENT->save();

            // Event
            event(new PlanEmails($this->user, $plan));

            // Return back
            return redirect()->route('user-mix')->with('success', __('Plan Activated Successfully'));
        }


        return fancy_error(__('General Error'), __("Unable to verify payment. Please try again."));

    }
}
