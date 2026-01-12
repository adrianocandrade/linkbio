<?php

namespace Sandy\Blocks\course\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Traits\Courses;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Traits\Mix\LessonInfo;
use Sandy\Blocks\course\Models\CoursesLesson;
use Sandy\Blocks\course\Models\CoursesReview;
use Sandy\Blocks\course\Traits\Course\Enrollments;

class CoursesController extends Controller{
    use Courses, LessonInfo, Enrollments;


    public function single(Request $request){
        if (!plan('settings.block_course', $this->bio->id)) {
            abort(404);
        }
        
        $has_course = $this->has_enroll($this->bio->id, $request->id);
        $course = Course::where('user', $this->bio->id)->where('id', $request->id)->first();

        if (!$course) {
            abort(404);
        }
        $lesson_icons = $this->lesson_skeleton();
        $types_icon = function($type) use ($lesson_icons){
            return ao($lesson_icons, "$type.icon");
        };
        $lessons = CoursesLesson::where('course_id', $course->id)->where('user', $this->bio->id)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();

        $review = CoursesReview::where('user', $this->bio->id)->where('course_id', $course->id)->orderBy('id', 'DESC')->get();

        return view('Blocks-course::bio.single', ['course' => $course, 'lessons' => $lessons, 'types_icon' => $types_icon, 'has_course' => $has_course, 'review' => $review]);
    }


    public function post_review(Request $request){
        if (!$course = Course::where('user', $this->bio->id)->where('id', $request->id)->first()) {
            abort(404);
        }

        if (!$has_course = $this->has_enroll($this->bio->id, $request->id)) {
            return back()->with('error', __('Please unlock this course to leave review.'));
        }

        if (!$user = \Auth::user()) {
            return back()->with('error', __('Login to continue'));
        }

        $request->validate([
            'review' => 'max:500'
        ]);

        if (CoursesReview::where('user', $this->bio->id)->where('reviewer_id', $user->id)->where('course_id', $course->id)->first()) {
            return back()->with('error', __('Cannot repost another review.'));
        }

        $review = new CoursesReview;
        $review->user = $this->bio->id;
        $review->reviewer_id = $user->id;
        $review->course_id = $course->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();


        return back()->with('success', __('Review submitted.'));
    }
}