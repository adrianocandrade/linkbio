<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PlanPayment;
use App\Models\PendingPlan;
use App\Events\PlanEmails;

class PaymentController extends Controller{
    public function payments(Request $request){
        $payments = PlanPayment::orderBy('id', 'DESC');


        if (!empty($email = $request->get('email'))) {
            $payments = $payments->where('email', 'LIKE','%'.$email.'%');
        }
        $payments = $payments->get();


        // Pending

        $pendingCount = PendingPlan::where('status', 0)->count();

        return view('admin::payments.all', ['payments' => $payments, 'pendingCount' => $pendingCount]);
    }


    public function pending(Request $request){

        // Get All Pending Payments
        $pending = PendingPlan::orderBy('id', 'DESC');

        //Query Type
        $searchBy = $request->get('search_by');
        if (!in_array($searchBy, ['email', 'name', 'ref'])) {
            $searchBy = 'ref';
        }

        // Query
        if (!empty($query = $request->get('query'))) {
            $query = str_replace('#', '', $query);
            $pending = $pending->where($searchBy, 'LIKE','%'.$query.'%');
        }

        // Status
        if (!empty($status = $request->get('status'))) {
            if (in_array($status, ['confirmed', 'unconfirmed'])) {
                switch ($status) {
                    case 'confirmed':
                        $status = 1;
                    break;

                    case 'unconfirmed': 
                        $status = 0;
                    break;
                }

                $pending = $pending->where('status', $status);
            }
        }

        //
        $pending = $pending->get();

        // Return the view
        return view('admin::payments.pending', ['pending' => $pending, 'searchBy' => $searchBy]);
    }



    public function pendingPost($type, Request $request){
        if (!$pending = PendingPlan::where('id', $request->pending)->first()) {
            abort(404);
        }

        if ($pending->status) {
            return back()->with('error', __('Cant use already confirmed Payment.'));
        }

        if (!in_array($type, ['accept', 'decline'])) {
            abort(403);
        }

        if ($type == 'decline') {
            $pending->status = 0;
            $pending->save();


            return back()->with('success', __('Plan Declined Successfully'));
        }


        // Get Duration DATE
        $duration = $pending->duration;
        $duration_time = \Carbon\Carbon::now(settings('others.timezone'));
        switch ($duration) {
            case 'annually':
                $duration_time->addMonths(12);
            break;
            case 'monthly':
                $duration_time->addMonths(1);
            break;
        }

        // Plan
        $plan = $pending->plan;
        $user_id = $pending->user;


        // Activate
        $activate = ActivatePlan($user_id, $plan, $duration_time);

        if (!ao($activate, 'status')) {
            return fancy_error(__('Dev Error'), ao($activate, 'response'));
        }

        $paymentArray = [
            'user'          => $user_id,
            'name'          => user('name', $user_id),
            'plan'          => $plan,
            'plan_name'     => GetPlan('name', $plan),
            'email'         => user('email', $user_id),
            'ref'           => $pending->ref,
            'currency'      => settings('payment.currency'),
            'duration'      => $duration,
            'price'         => GetPlan('price.' . $duration, $plan),
            'gateway'       => __('Manual'),
            'created_at'    => \Carbon\Carbon::now(settings('others.timezone'))
        ];

        \App\Models\PlanPayment::insert($paymentArray);

        // Update Pending
        $pending->status = 1;
        $pending->update();
        // Event
        event(new PlanEmails(\App\User::find($user_id), $plan));

        // Return back
        return back()->with('success', __('Plan Activated Successfully'));
    }
}
