<?php

namespace Sandy\Payments\manual\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use App\Models\Plan;
use App\Models\PendingPlan;
use App\Payments;
use Route;
use App\Email;

class BankController{
    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'manual')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        if (!$plan = Plan::where('id', ao($spv->meta, 'plan'))->first()) {
            return fancy_error(__('Please try again.'), __('Plan Doesnt exists.'));
        }

        $pending = PendingPlan::where('plan', ao($spv->meta, 'plan'))->where('duration', ao($spv->meta, 'duration'))->where('user', ao($spv->meta, 'user'))->get();

        // View Page
        return view('Payment-manual::bank', ['sxref' => $sxref, 'plan' => $plan, 'spv' => $spv, 'pending' => $pending]);
    }

    public function post(Request $request){
        // Validate request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'bank_name' => 'required|string',
            'proof' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        // Get sxref from url
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'manual')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        // Get Plan
        if (!$plan = Plan::where('id', ao($spv->meta, 'plan'))->first()) {
            return fancy_error(__('Please try again.'), __('Plan Doesnt exists.'));
        }

        // Check if pending request already exists        
        if (PendingPlan::where('user', ao($spv->meta, 'user'))->where('duration', ao($spv->meta, 'duration'))->where('plan', ao($spv->meta, 'plan'))->where('status', 0)->first()) {
            return back()->with('error', __('A pending request already exists. Please wait for it to be approved.'));
        }

        $info = [];

        $info['bank_name'] = $request->bank_name;

        if (!empty($request->proof)) {
            $imageName = md5(microtime());
            $info['proof'] = putStorage('media/site/manual-payment', $request->proof);
        }

        $create = new PendingPlan;
        $create->user = ao($spv->meta, 'user');
        $create->name = $request->name;
        $create->plan = ao($spv->meta, 'plan');
        $create->ref = \Str::random(5);
        $create->info = $info;
        $create->duration = ao($spv->meta, 'duration');

        $create->save();

        // Send email
        $this->send_email(ao($spv->meta, 'user'), ao($spv->meta, 'plan'));

        return back()->with('success', __('Request placed. Plan will be activated soon.'));
    }


    public function send_email($user_id, $plan){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        if (!settings("notification.pending_plan")) {
            return false;
        }

        // Emails
        $emails = settings('notification.emails');
        $emails = explode(',', $emails);
        $emails = str_replace(' ', '', $emails);

        // Email class
        $email = new Email;
        // Get email template
        $template = $email->template('admin/pending_plan', ['user' => $user, 'plan' => $plan]);
        // Email array
        $mail = [
            'to' => $emails,
            'subject' => __('Bank Transfer', ['website' => config('app.name')]),
            'body' => $template
        ];

        // Send Email
        $email->send($mail);
    }


    public function delete($id, Request $request){
        $pending = PendingPlan::find($id);
        if (!$pending) {
            abort(404);
        }

        if (!empty($proof = ao($pending->info, 'proof'))) {
            if(mediaExists('media/site/manual-payment', $proof)){
                storageDelete('media/site/manual-payment', $proof); 
            }
        }

        $pending->delete();

        return back()->with('success', __('Request Removed'));
    }
}