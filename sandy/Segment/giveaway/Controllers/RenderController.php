<?php

namespace Sandy\Segment\giveaway\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function DateOfB(){
        $returned = [];

        $base_year = (int) date('Y');
        $start_year = 1900;
        for( $i = $start_year; $i <= $base_year; $i++){
            $returned['year'][$i] = $i;
        }

        $months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
        $transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
        $last8 = array_reverse(array_slice($transposed, -8, 12, true), true);


        $returned['months'] = $months;


        for ($i= 1; $i < 32; $i++) { 
            $returned['days'][$i] = $i;
        }


        return $returned;
    }

    public function render(){
        $date = $this->DateOfB();
        // \Route::getRoutes()->getByName('sandy-app-textarea-edit')->getActionName();
        return view("App-$this->name::render", ['date' => $date]);
    }


    public function postSubmission($slug, Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $element = $this->element;

        $content = [
            'email' => $request->email
        ];

        if (Elementdb::where('email', $request->email)->where('element', $this->element->id)->first()) {
            return back()->with('error', __('Email has already been used.'));
        }

        if (ao($element->content, 'phone')) {
            $request->validate([
                'phone' => 'required|string'
            ]);

            $content['phone'] = $request->phone;
        }
        if (ao($element->content, 'first_name')) {
            $request->validate([
                'first_name' => 'required|string'
            ]);

            $content['first_name'] = $request->first_name;
        }
        if (ao($element->content, 'last_name')) {
            $request->validate([
                'last_name' => 'required|string'
            ]);

            $content['last_name'] = $request->last_name;
        }
        // DB

        if (ao($element->content, 'dob')) {
            $request->validate([
                'dob' => 'required'
            ]);

            if (!empty($request->dob)) {
                $dob = implode(' / ', $request->dob);
                
                $content['dob'] = $dob;
            }
        }

        $db = $content;

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->email = $request->email;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();

        // INTEGRATION: AUDIENCE SERVICE
        try {
            $workspaceId = $this->workspace->id ?? (\App\Models\Workspace::where('user_id', $this->bio->id)->where('is_default', 1)->first()->id ?? null);
            
            $name = trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? ''));
            if (empty($name)) $name = $request->email;

            $audienceService = app(\Modules\Mix\Services\AudienceService::class);
            $contact = $audienceService->createOrUpdateContact([
                'workspace_id' => $workspaceId,
                'user_id' => $this->bio->id,
                'name' => $name,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'source' => 'giveaway',
                'source_id' => $database->id,
            ]);

            $audienceService->recordInteraction(
                $contact->id,
                'giveaway',
                'entered'
            );
        } catch (\Exception $e) {
            \Log::error('Audience Integration Error (Giveaway): ' . $e->getMessage());
        }

        return redirect()->route('sandy-app-giveaway-render', ['slug' => $slug])->with('info', __('Your info has been successfully submitted for the giveaway.'));
    }
}