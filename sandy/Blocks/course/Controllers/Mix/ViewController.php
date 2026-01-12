<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Models\Course;

class ViewController extends Controller{

    public function view(Request $request){
        $course = Course::where('user', $this->user->id)->where('id', $request->id)->first();
        if (!$course) {
            abort(404);
        }

        return view('Blocks-course::mix.view', ['course' => $course]);
    }
}
