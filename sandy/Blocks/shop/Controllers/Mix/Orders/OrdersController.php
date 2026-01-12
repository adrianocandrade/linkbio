<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Orders;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\ProductOrder;
use Sandy\Blocks\shop\Models\ProductOrderTimeline;

class OrdersController extends Controller{

    public function orders(Request $request){
        $orders = ProductOrder::where('user', $this->user->id)->orderBy('id', 'DESC');

        if (!empty($query_id = $request->get('query_id'))) {
            $query_id = str_replace('#', '', $query_id);
            $orders = $orders->where('id', 'LIKE','%'.$query_id.'%');
        }

        $orders = $orders->paginate(10);

        $order_status = function($status){
            if ($status == 1) {
                return __('Pending');
            }

            if ($status == 2) {
                return __('Completed');
            }

            if ($status == 3) {
                return __('Canceled');
            }
        };
        return view('Blocks-shop::mix.orders.orders', ['orders' => $orders, 'order_status' => $order_status]);
    }

    public function single($id){
        if (!$order = ProductOrder::where('id', $id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $order_status = function($status){
            if ($status == 1) {
                return __('Pending');
            }

            if ($status == 2) {
                return __('Completed');
            }

            if ($status == 3) {
                return __('Canceled');
            }
        };

        $timeline = ProductOrderTimeline::where('tid', $order->id)->where('user', $this->user->id)->orderBy('id', 'DESC')->get();

        return view('Blocks-shop::mix.orders.single', ['order' => $order, 'timeline' => $timeline, 'order_status' => $order_status]);
    }


    public function status($id, $type){
        $types = ['resend_order', 'completed', 'canceled'];

        if (!in_array($type, $types)) {
            abort(404);
        }

        if (!$order = ProductOrder::where('id', $id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $user = $this->user;

        $timeline = function($data, $type) use ($order, $user){
            $ordertimeline = new ProductOrderTimeline;
            $ordertimeline->user = $user->id;
            $ordertimeline->tid = $order->id;
            $ordertimeline->type = $type;
            $ordertimeline->data = $data;
            $ordertimeline->save();
        };



        if ($type == 'resend_order') {


            // Resend Email
            $data = [
                'email' => $order->email
            ];  

            dispatch(function() use ($order){
                if (!$payee = \App\User::find($order->payee_user_id)) {
                    return false;
                }

                // Email class
                $email = new \App\Email;
                // Get email template
                $template = $email->template(block_path('shop', 'Email/purchased_product_email.php'), ['order' => $order, 'order_id' => $order->id]);
                // Email array
                $mail = [
                    'to' => $order->email,
                    'subject' => __('Your purchased product(s)', ['website' => config('app.name')]),
                    'body' => $template
                ];

                $email->send($mail);
            });

            $timeline($data, 'resend_order');

            return back()->with('success', __('Order receipt has been sent.'));
        }


        if ($type == 'canceled') {
            if (ProductOrderTimeline::where('type', 'canceled_order')->where('tid', $order->id)->first()) {
                return back()->with('info', __('Cannot re-mark a canceled order'));
            }

            // Resend Email
            $data = [
                'email' => $order->email
            ];  

            $order->status = 3;
            $order->update();

            $timeline($data, 'canceled_order');

            return back()->with('success', __('Order has been canceled.'));
        }

        if ($type == 'completed') {
            if (ProductOrderTimeline::where('type', 'completed_order')->where('tid', $order->id)->first()) {
                return back()->with('info', __('Cannot re-mark a completed order'));
            }


            // Resend Email
            $data = [
                'email' => $order->email
            ];  

            $order->status = 2;
            $order->update();

            $timeline($data, 'completed_order');

            return back()->with('success', __('Order has been completed.'));
        }
    }
}
