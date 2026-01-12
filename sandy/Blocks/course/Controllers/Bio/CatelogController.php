<?php

namespace Sandy\Blocks\course\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Models\Course;

class CatelogController extends Controller{

    public function catelog(){
        if (!plan('settings.block_course', $this->bio->id)) {
            abort(404);
        }
        
        $courses = Course::where('user', $this->bio->id)->get();
        return view('Blocks-course::bio.index', ['courses' => $courses]);
    }
}