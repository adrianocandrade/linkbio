<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Traits\Mix\LessonInfo;
use Sandy\Blocks\course\Models\CoursesLesson;

class LessonController extends Controller{

    use LessonInfo;

    public function lesson(Request $request){
        $lesson_types = $this->lesson_skeleton();
        $types_icon = function($type) use ($lesson_types){
            return ao($lesson_types, "$type.icon");
        };

        $course = Course::where('user', $this->user->id)->where('id', $request->id)->first();
        if (!$course) {
            abort(404);
        }

        $lessons = CoursesLesson::where('course_id', $course->id)->where('user', $this->user->id)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();

        return view('Blocks-course::mix.lesson.index', ['course' => $course, 'lessons' => $lessons, 'types_icon' => $types_icon, 'lesson_types' => $lesson_types]);
    }

    public function lesson_sort($id, Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = CoursesLesson::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }

    public function lesson_types($id, $type){
        $course = Course::where('user', $this->user->id)->where('id', $id)->first();
        if (!$course) {
            abort(404);
        }

        $types = $this->lesson_skeleton();

        if (!array_key_exists($type, $types)) {
            abort(404);
        }


        return view('Blocks-course::mix.lesson.lesson', ['course' => $course, 'type' => $type, 'video_skel' => $this->video_skel()]);
    }

    public function post($id, $type, Request $request){
        $course = Course::where('user', $this->user->id)->where('id', $id)->first();
        if (!$course) {
            abort(404);
        }

        $types = $this->lesson_skeleton();

        if (!array_key_exists($type, $types)) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'duration' => 'required'
        ]);

        $data = [];

        if (!empty($request->data)) {
            foreach ($request->data as $key => $value) {
                $data[$key] = $value;
            }
        }

        if ($type == 'video') {
            $data = $this->process_video($data, $request);
        }



        $lesson = new CoursesLesson;
        $lesson->user = $this->user->id;
        $lesson->course_id = $course->id;
        $lesson->name = $request->name;
        $lesson->description = $request->description;
        $lesson->lesson_type = $type;
        $lesson->status = 1;
        $lesson->lesson_duration = $request->duration;
        $lesson->lesson_data = $data;
        $lesson->save();



        return redirect()->route('sandy-blocks-course-mix-lessons', $course->id)->with('success', __('Saved successfully'));
    }


    public function process_video($data, $request){
        $data['is_iframe'] = $this->isIframe(ao($data, 'type'));
        $data['thumbnail'] = getVideoBlocksThumbnail(ao($data, 'type'), ao($data, 'link'));


        return $data;
    }

    public function process_image($data, $request){

    }
}
