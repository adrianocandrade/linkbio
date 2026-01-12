<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Models\CoursesLesson;

class EditController extends Controller{

    public function edit($id){
        $course = Course::where('user', $this->user->id)->where('id', $id)->first();
        if (!$course) {
            abort(404);
        }

        return view('Blocks-course::mix.edit', ['course' => $course]);
    }

    public function post($id, Request $request){
        $course = Course::where('user', $this->user->id)->where('id', $id)->first();
        if (!$course) {
            abort(404);
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $includes = [];

        if (!empty($includes_input = $request->includes)) {
            foreach ($includes_input as $key => $value) {
                $includes[] = ao($value, 'includes');
            }
        }


        if ($request->expiry_type) {
            $request->validate([
                'expry_days' => 'required|numeric|min:1'
            ]);
        }

        $banner = sandy_upload_modal_upload($request, 'media/courses/banner', '2048', $this->user->id, $course->banner);


        $course->name = $request->name;
        $course->user = $this->user->id;

        $course->price = $request->price;
        $course->price_type = $request->price_type;
        $course->status = 1;
        $course->description = $request->description;
        $course->course_level = $request->course_level;
        $course->course_duration = $request->course_duration;
        $course->course_includes = $includes;
        $course->banner = $banner;

        $course->course_expiry_type = $request->expiry_type;
        $course->course_expiry = $request->expry_days;

        $course->update();


        return back()->with('success', __('Saved successfully.'));
    }

    public function delete($id){
        $course = Course::where('user', $this->user->id)->where('id', $id)->first();
        if (!$course) {
            abort(404);
        }



        if (!empty(ao($course->banner, 'upload')) && mediaExists('media/courses/banner', ao($course->banner, 'upload'))) {
            storageDelete('media/courses/banner', ao($course->banner, 'upload')); 
        }


        $lesson = CoursesLesson::where('course_id', $course->id)->delete();

        $course->delete();


        return redirect()->route('sandy-blocks-course-mix-dashboard')->with('success', __('Course deleted successfully'));

    }
}
