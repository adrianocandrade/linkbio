<?php

namespace Sandy\Blocks\shop\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class SettingsController extends Controller
{
    public function settings(){
        return view('Blocks-shop::mix.settings');
    }

    public function setting_post(Request $request){
        $user = $this->user;

        $store = $user->settings;


        if (!empty($store_loop = $request->store)) {
            foreach ($store_loop as $key => $value) {
                $store['store'][$key] = $value;
            }
        }


        $user->settings = $store;
        $user->update();

        return back()->with('success', __('Store settings updated successfully.'));
    }
}
