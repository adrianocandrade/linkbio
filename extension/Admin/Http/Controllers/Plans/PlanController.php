<?php

namespace Modules\Admin\Http\Controllers\Plans;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Plan;
use App\User;

class PlanController extends Controller{
    public function plans(){
        $plans = Plan::orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();
        return view('admin::plans.all', ['plans' => $plans]);
    }

    public function new(){
        $skeleton = getOtherResourceFile('plan');
        return view('admin::plans.new', ['skeleton' => $skeleton]);
    }

    public function AddToUser(Request $request){
        $request->validate([
            'date' => 'required'
        ]);

        if (!$plan = Plan::find($request->plan_id)) {
            return back()->with('error', __('Plan not found'));
        }

        if (!$user = User::find($request->user_id)) {
            return back()->with('error', __('User not found'));
        }

        if (!validate_date_string($request->date)) {
            return back()->with('error', __('Date not valid'));
        }

        $user_id = $user->id;

        $duration_time = \Carbon\Carbon::parse($request->date);
        $activate = ActivatePlan($user->id, $plan->id, $duration_time);
        if (!ao($activate, 'status')) {
            return back()->with('error', ao($activate, 'response'));
        }

        return back()->with('success', __('Plan added to user'));
    }

    public function delete($id, Plan $plan){
        // Check if plan exists
        if (!$plan = $plan->find($id)) {
            abort(404);
        }

        $plan_name = $plan->name;

        \App\Models\PlansHistory::where('plan_id', $plan->id)->delete();

        $plan->delete();

        return redirect()->route('admin-plans')->with('success', __('Plan deleted.'));
    }


    public function edit($id, Plan $plan){
        // Skeleton plan
        $skeleton = getOtherResourceFile('plan');

        // Check if plan exists
        if (!$plan = $plan->find($id)) {
            abort(404);
        }

        // Safe settings function variable returns false if error

        $settings = function($setting, $key){
            $temp = $setting;

            app('config')->set('plan-setting-temp', $temp);

            // Add to app config
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('plan-setting-temp'. $key);
        };

        // Return our view
        return view('admin::plans.edit', ['plan' => $plan, 'settings' => $settings, 'skeleton' => $skeleton]);
    }


    public function editPost($id, Request $request, Plan $plan){
        // Validate request
        $this->validate($request);

        foreach ($plan->get() as $value) {
            $update = $plan->find($value->id);
            $extra = $value->extra;
            if (!empty($request->extra['featured']) && $request->extra['featured']) {
                $extra['featured'] = 0;
            }
            if ($request->defaults) {
                $update->defaults = 0;
            }
            $update->extra = $extra;
            $update->save();
        }

        // Check if plan exists
        if (!$plan = $plan->find($id)) {
            abort(404);
        }

        // Loop & post settings
        $settings = [];

        if (!empty($setting = $request->settings)) {

            // Loop setting
            foreach($setting as $key => $value){
                $settings[$key] = $value;
            }
        }


        // Loop & post Extra
        $extra = $plan->extra;

        if (!empty($extra = $request->extra)) {

            // Loop setting
            foreach($extra as $key => $value){
                $extra[$key] = $value;
            }
        }

        // Loop & post price
        $prices = [];

        if (!empty($price = $request->price)) {

            // Loop price
            foreach($price as $key => $value){
                $prices[$key] = $value;
            }
        }




        // Post plan
        $plan->name = $request->name;
        $plan->status = $request->status;
        $plan->defaults = $request->defaults;
        $plan->price = $prices;
        $plan->settings = $settings;
        $plan->extra = $extra;
        $plan->price_type = $request->type;
        $plan->save();

        // Return back
        return back()->with('success', __('Saved Successfully'));
    }


    public function newPost(Request $request){
        // Validate request
        $this->validate($request);

        foreach (Plan::get() as $value) {
            $update = Plan::find($value->id);
            $extra = $value->extra;
            if (!empty($request->extra['featured']) && $request->extra['featured']) {
                $extra['featured'] = 0;
            }
            if ($request->defaults) {
                $update->defaults = 0;
            }

            $update->extra = $extra;
            $update->save();
        }

        // Loop & post settings
        $settings = [];

        if (!empty($setting = $request->settings)) {

            // Loop setting
            foreach($setting as $key => $value){
                $settings[$key] = $value;
            }
        }

        // Loop & post price
        $prices = [];

        if (!empty($price = $request->price)) {

            // Loop price
            foreach($price as $key => $value){
                $prices[$key] = $value;
            }
        }

        // Loop & post Extra
        $extra = [];

        if (!empty($extra = $request->extra)) {

            // Loop setting
            foreach($extra as $key => $value){
                $extra[$key] = $value;
            }
        }


        // Post plan
        $plan = new Plan;
        $plan->name = $request->name;
        $plan->status = $request->status;
        $plan->defaults = $request->defaults;
        $plan->price = $prices;
        $plan->settings = $settings;
        $plan->extra = $extra;
        $plan->price_type = $request->type;
        $plan->save();

        // Return back

        return redirect()->route('admin-plans')->with('success', __('Saved Successfully'));
    }


    private function validate($request){
        $request->validate([
            'name' => 'required',
            'settings.blocks_limit' => 'required|numeric|min:1',
            'settings.pixel_limit' => 'required|numeric',
            'settings.workspaces_limit' => 'required|numeric|min:1'
        ]);


        if ($request->type == 'trial') {
            $request->validate([
                'price.trial_duration' => 'required|numeric|min:1'
            ]);
        }

        if ($request->type == 'paid') {
            $request->validate([
                'price.monthly' => 'required|numeric',
                'price.annually' => 'required|numeric'
            ]);
        }
    }

    public function sort(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = Plan::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }
}
