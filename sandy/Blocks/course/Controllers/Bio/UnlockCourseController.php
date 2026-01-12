<?php

namespace Sandy\Blocks\course\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Traits\Courses;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Models\CoursesOrder;
use Sandy\Blocks\course\Models\CoursesEnrollment;
use App\Payments;

class UnlockCourseController extends Controller{
    use Courses;

    public function pay(Request $request){
        $payment = new Payments();
        $course = Course::where('user', $this->bio->id)->where('id', $request->id)->first();
        if (!$course) {
            abort(404);
        }


        if (!$auth_user = \Auth::user()) {
            return back()->with('error', __('Please login to proceed.'));
        }


        $sxref = \Bio::sxref();
        $method = ao($this->bio->payments, 'default');
        $callback = \Bio::route($this->bio->id, 'sandy-blocks-course-unlock', ['sxref' => $sxref]);

        $item = [
            'name' => $course->name,
            'description' => __('Purchased a course on :page', ['page' => $this->bio->name]),
            'processing_description' => __('Purchasing ":course" on :page', ['page' => $this->bio->name, 'course' => $course->name]),
            'processed_description' => __('Just purchased <strong>:course</strong> for <strong>:amount</strong>', ['page' => $this->bio->name, 'course' => $course->name, 'amount' => $course->price])
        ];

        $meta = [
            'bio_id' => $this->bio->id,
            'course' => $course->id,
            'payee_id' => $auth_user->id,
            'item' => $item
        ];

        $data = [
            'method' => $method,
            'email' => $auth_user->email,
            'price' => $course->price,
            'callback' => $callback,
            'currency' => ao($this->bio->payments, 'currency')
        ];

        $keys = user("payments.$method", $this->bio->id);

        $create = $payment->create($sxref, $data, $keys, $meta);

        // Return the gateway
        return $create;
    }

    public function unlock(Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if (!$spv = Payments::is_paid($sxref)) {
            abort(404);
        }

        if (!$payee = \App\User::find(ao($spv->meta, 'payee_id'))) {
            return false;
        }
            
        // Email class
        $email = new \App\Email;
        // Get email template
        $template = $email->template(block_path('course', 'Email/unlocked_course_email.php'), ['spv' => $spv]);
        // Email array
        $mail = [
            'to' => $payee->email,
            'subject' => __('You unlocked :course', ['website' => config('app.name'), 'course' => ao($spv->meta, 'item.name')]),
            'body' => $template
        ];

        $email->send($mail);

        // Send Email - FIX
        //dispatch(function() use ($spv){

        //});

        $course_id = ao($spv->meta, 'course');
        // Enroll
        $this->enroll($this->bio->id, ao($spv->meta, 'payee_id'), ao($spv->meta, 'course'));

        // Order
        $this->order($this->bio->id, ao($spv->meta, 'payee_id'), ao($spv->meta, 'course'), $spv);


        $return = \Bio::route($this->bio->id, 'sandy-blocks-course-single-course', ['id' => $course_id]);

        return redirect($return)->with('payment_success', ['item' => ao($spv->meta, 'item'), 'response' => __('Your course has been successfully unlocked. ')]);
    }


    private function enroll($user_id, $payee_id, $course_id){
        if ($check = CoursesEnrollment::where('user', $user_id)->where('payee_user_id', $payee_id)->where('course_id', $course_id)->first()) {
            $check->update();
        }

        $enroll = new CoursesEnrollment;
        $enroll->user = $user_id;
        $enroll->payee_user_id = $payee_id;
        $enroll->course_id = $course_id;
        $enroll->save();

        return true;
    }


    private function order($user_id, $payee_id, $course_id, $spv){
        $order = new CoursesOrder;
        $order->user = $user_id;
        $order->payee_user_id = $payee_id;
        $order->course_id = $course_id;
        $order->email = $spv->email;
        $order->price = $spv->price;
        $order->currency = $spv->currency;
        $order->ref = $spv->method_ref;
        $order->status = 1;
        $order->save();

        return true;

    }


    public function send_email(Request $request){

    }
}