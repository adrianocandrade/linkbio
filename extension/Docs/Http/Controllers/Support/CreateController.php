<?php

namespace Modules\Docs\Http\Controllers\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\SupportConversation;
use App\Email;

class CreateController extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function view(Request $request){

        // Return view
        return view('docs::support.create.view');
    }


    public function post(Request $request){
        if (!plan('settings.support')) {
            abort(404);
        }

        $request->validate([
            'subject' => 'required',
            'description'  => 'required|max:200'
        ]);


        $conversation = new SupportConversation;
        $conversation->user = $this->user->id;
        $conversation->topic = $request->subject;
        $conversation->description = $request->description;
        $conversation->save();

        // Send email
        $this->send_email($this->user, $request->subject, $request->description);

        return redirect()->route('user-support-view', $conversation->id)->with('success', __('Support Created'));
    }

    public function send_email($user, $ticket_subject, $description){
        if (!settings("notification.new_support")) {
            return false;
        }
        $subject = __('New pending support from :name', ['name' => $user->name]);

        Email::notify_admin($subject, 'admin/new_support', ['user' => $user, 'subject' => $ticket_subject, 'description' => $description]);
    }
}
