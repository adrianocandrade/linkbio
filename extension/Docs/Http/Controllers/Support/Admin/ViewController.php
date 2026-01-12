<?php

namespace Modules\Docs\Http\Controllers\Support\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SupportMessage;
use App\Models\SupportConversation;

class ViewController extends Controller{
    public function view($id, Request $request){
        if (!$conversation = SupportConversation::where('id', $id)->first()) {
            abort(404);
        }

        // Return view
        return view('docs::support.admin.view', ['conversation' => $conversation]);
    }

    public function get_messages($id){
        if (!$conversation = SupportConversation::where('id', $id)->first()) {
            abort(404);
        }


        return support_conversation_messages($conversation->id);
    }
}
