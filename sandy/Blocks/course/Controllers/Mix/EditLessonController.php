<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Traits\Mix\LessonInfo;
use Sandy\Blocks\course\Models\CoursesLesson;

use Sandy\Blocks\course\Models\Course;

class EditLessonController extends Controller{
    use LessonInfo;

    public function edit($id){
        $lesson = CoursesLesson::where('user', $this->user->id)->where('id', $id)->first();
        if (!$lesson) {
            abort(404);
        }

        $types = $this->lesson_skeleton();

        if (!array_key_exists($lesson->lesson_type, $types)) {
            abort(404);
        }


        return view('Blocks-course::mix.lesson.lesson-edit', ['lesson' => $lesson, 'video_skel' => $this->video_skel()]);
    }

    public function post($id, Request $request){
        $lesson = CoursesLesson::where('user', $this->user->id)->where('id', $id)->first();
        if (!$lesson) {
            abort(404);
        }

        $types = $this->lesson_skeleton();

        if (!array_key_exists($lesson->lesson_type, $types)) {
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

        if ($lesson->lesson_type == 'video') {
            $data = $this->process_video($data, $request);
        }



        $lesson->name = $request->name;
        $lesson->description = $request->description;
        $lesson->status = 1;
        $lesson->lesson_duration = $request->duration;
        $lesson->lesson_data = $data;
        $lesson->update();



        return back()->with('success', __('Saved successfully'));
    }

    public function process_video($data, $request){
        $data['is_iframe'] = $this->isIframe(ao($data, 'type'));
        $data['thumbnail'] = getVideoBlocksThumbnail(ao($data, 'type'), ao($data, 'link'));


        return $data;
    }

    public function delete($id, Request $request){
        $lesson = CoursesLesson::where('user', $this->user->id)->where('id', $id)->first();
        if (!$lesson) {
            abort(404);
        }

        $lesson->delete();


        return back()->with('success', __('Lesson deleted successfully.'));
    }
}
