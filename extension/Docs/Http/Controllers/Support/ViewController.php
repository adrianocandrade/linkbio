<?php

namespace Modules\Docs\Http\Controllers\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\SupportMessage;
use App\Models\SupportConversation;

class ViewController extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function view($id, Request $request){
        if (!$conversation = SupportConversation::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }


        $messages = SupportMessage::where('conversation_id', $conversation->id)->update(['seen' => 1]);

        // Return view
        return view('docs::support.view', ['conversation' => $conversation]);
    }
    public function get_messages($id){
        if (!$conversation = SupportConversation::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }


        return support_conversation_messages($conversation->id);
    }
}
