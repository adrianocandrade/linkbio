<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Models\CoursesOrder;
use Sandy\Blocks\course\Traits\Courses;

class SalesController extends Controller{
    use Courses;

    public function sales(Request $request){
        $courses = Course::where('user', $this->user->id)->get();
        $analytics = $this->sales_analytics($request);

        $orders = CoursesOrder::where('user', $this->user->id)->orderBy('id', 'DESC')->paginate(15);

        return view('Blocks-course::mix.sales', ['courses' => $courses, 'analytics' => $analytics, 'orders' => $orders]);
    }
}
