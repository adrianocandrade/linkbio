<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class SettingsController extends Controller
{
    public function settings(){
        return view('Blocks-course::mix.settings');
    }

    public function setting_post(Request $request){
        $user = $this->user;

        $course = $user->settings;


        if (!empty($course_loop = $request->course)) {
            foreach ($course_loop as $key => $value) {
                $course['course'][$key] = $value;
            }
        }


        $user->settings = $course;
        $user->update();

        return back()->with('success', __('Course settings updated successfully.'));
    }
}
