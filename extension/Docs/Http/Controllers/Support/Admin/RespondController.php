<?php

namespace Modules\Docs\Http\Controllers\Support\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\SupportMessage;
use App\Models\SupportConversation;

class RespondController extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function respond(Request $request){
        if (!$conversation = SupportConversation::where('id', $request->conversation_id)->first()) {
            return back()->with('error', __('Could not find conversation.'));
        }



        $type = $request->message_type;
        $data = null;

        switch ($type) {
            case 'text':
                $request->validate([
                    'message' => 'required'
                ]);
                $data = $request->message;
            break;

            case 'link':
                $request->validate([
                    'link' => 'required'
                ]);
                $data = $request->link;
            break;

            case 'image':
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2024'
                ]);

                $image = \UserStorage::put('media/site/support', $request->image, $this->user->id);
                $data = $image;
            break;

            case 'file':
                $request->validate([
                    'file' => 'file'
                ]);

                $file = \UserStorage::put('media/site/support', $request->file, $this->user->id);
                $data = $file;
            break;
        }


        $message = new SupportMessage;
        $message->conversation_id = $conversation->id;
        $message->from = 'support';
        $message->from_id = $this->user->id;
        $message->type = $type;
        $message->data = $data;
        $message->save();

        return back()->with('success', __('Support updated'));
    }


    public function close($id){
        if (!$conversation = SupportConversation::where('id', $id)->first()) {
            return back()->with('error', __('Could not find conversation.'));
        }


        $conversation->status = 0;

        $conversation->update();


        return back()->with('success', __('Conversation updated'));
    }
}
