<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

use Sandy\Blocks\course\Models\Course;

class NewController extends Controller{

    public function new(){
        return view('Blocks-course::mix.new');
    }

    public function create_block(){
        if (!Course::where('user', $this->user->id)->get()->isEmpty() && !\App\Models\Block::where('user', $this->user->id)->where('block', 'course')->first()) {

            $data = [
                'blocks' => [
                    'all_course' => 1
                ]
            ];

            \Blocks::create_block_sections($this->user->id, 'course', $data);
        }
    }

    public function post(Request $request){
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

        $banner = sandy_upload_modal_upload($request, 'media/courses/banner', '2048', $this->user->id);

        $course = new Course;

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

        $course->save();

        $this->create_block();

        return redirect()->route('sandy-blocks-course-mix-lessons', $course->id)->with('success', __('Saved successfully.'));
    }
}
