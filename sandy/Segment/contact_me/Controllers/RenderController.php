<?php

namespace Sandy\Segment\contact_me\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;
use App\Email;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render(){
        \Elements::makePublic($this->name);
        return view("App-$this->name::render");
    }

    public function sendMessage(Request $request){
        // Captcha here
        \SandyCaptcha::validator($request);
        // Validate
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        // Email class
        $email = new Email;
        // Get email template
        $template = $request->message;
        // Email array
        $mail = [
            'from' => $request->email,
            'to' => $this->bio->email,
            'subject' => $request->subject,
            'body' => $template
        ];


        $email->send($mail);



        $db = [
            'subject' => $request->subject,
            'email' => $request->email,
            'message' => $request->message
        ];

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->email = $request->email;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();

        // INTEGRATION: AUDIENCE SERVICE
        try {
            $workspaceId = $this->workspace->id ?? (\App\Models\Workspace::where('user_id', $this->bio->id)->where('is_default', 1)->first()->id ?? null);
            
            $audienceService = app(\Modules\Mix\Services\AudienceService::class);
            $contact = $audienceService->createOrUpdateContact([
                'workspace_id' => $workspaceId,
                'user_id' => $this->bio->id,
                'name' => $request->name ?? $request->email, // Try to find name if present in request
                'email' => $request->email,
                'source' => 'contact_me',
                'source_id' => $database->id,
            ]);

            $audienceService->recordInteraction(
                $contact->id,
                'message',
                'sent',
                0,
                ['subject' => $request->subject]
            );
        } catch (\Exception $e) {
            \Log::error('Audience Integration Error (ContactMe): ' . $e->getMessage());
        }


        return back()->with('success', __('Mail sent successfully'));
    }
}