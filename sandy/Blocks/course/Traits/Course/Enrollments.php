<?php

namespace Sandy\Blocks\course\Traits\Course;
use Illuminate\Http\Request;
use App\Traits\UserBioInfo;
use Illuminate\Support\Facades\View;
use Sandy\Blocks\course\Models\CoursesEnrollment;

trait Enrollments {
    public function has_enroll($bio_id, $course_id){
        if (!$payee = \Auth::user()) {
            return false;
        }

        // Check if its enrolled
        if (!$enrollment = CoursesEnrollment::where('user', $bio_id)->where('payee_user_id', $payee->id)->where('course_id', $course_id)->first()) {
            return false;
        }

        // Check if it's expired

        return $enrollment;
    }
}