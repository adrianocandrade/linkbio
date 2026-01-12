<?php

namespace Modules\Docs\Http\Controllers\Support\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SupportMessage;
use App\Models\SupportConversation;

class RequestController extends Controller{
    public function view(Request $request){
        $support = $this->get_with_filter($request);


        // Return view
        return view('docs::support.admin.requests', ['support' => $support]);
    }


    private function get_with_filter($request){
        $support = new SupportConversation;
        // Paginate results per page
        $paginate = (int) $request->get('per_page');
        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        // Query
        if (!empty($query = $request->get('query'))) {
            $support = $support->where('topic', 'LIKE','%'.$query.'%');
        }

        // User
        if (!empty($user = $request->get('user'))) {
            $support = $support->where('user', $user);
        }

        // Status
        if (!empty($status = $request->get('status'))) {
            if (in_array($status, ['opened', 'closed'])) {

                switch ($status) {
                    case 'opened':
                        $status = 1;
                    break;

                    case 'closed': 
                        $status = 0;
                    break;
                }

                $support = $support->where('status', $status);
            }
        }

        // Order Type
        $order_type = $request->get('order_type');
        if (!in_array($order_type, ['ASC', 'DESC'])) {
            $order_type = 'DESC';
        }
        // Order By
        $order_by = $request->get('order_by');
        if (!in_array($order_by, ['created_at'])) {
            $order_by = 'created_at';
        }

        $support = $support->orderBy($order_by, $order_type);

        // Returned Array of Paginate
        $support = $support->paginate(
            $paginate,
        )->onEachSide(1)->withQueryString();

        return $support;
    }
}
