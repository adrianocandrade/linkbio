<?php

namespace Sandy\Blocks\course\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Traits\Courses;
use Sandy\Blocks\course\Traits\Course\Enrollments;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Traits\Mix\LessonInfo;
use Sandy\Blocks\course\Models\CoursesLesson;

class LessonController extends Controller{
    use Courses, LessonInfo, Enrollments;

    public function take(Request $request){
        if (!plan('settings.block_course', $this->bio->id)) {
            abort(404);
        }
        
        if (!$course = Course::where('user', $this->bio->id)->where('id', $request->id)->first()) {
            abort(404);
        }

        if (!$this->has_enroll($this->bio->id, $request->id)) {
            return redirect(\Bio::route($this->bio->id, 'sandy-blocks-course-single-course', ['id' => $request->id]))->with('error', __('Please unlock course to have access.'));
        }

        $lesson_icons = $this->lesson_skeleton();
        $types_icon = function($type) use ($lesson_icons){
            return ao($lesson_icons, "$type.icon");
        };

        $lessons = CoursesLesson::where('course_id', $course->id)->where('user', $this->bio->id)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();

        return view('Blocks-course::bio.take-course', ['course' => $course, 'lessons' => $lessons, 'types_icon' => $types_icon]);
    }
}