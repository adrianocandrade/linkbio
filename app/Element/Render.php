<?php

namespace App\Element;

use App\User;
use App\Models\Element;
use App\Models\Elementdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Bio\Http\Traits\BioTraits;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Render extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, BioTraits;
    public $slug;
    public $element;
    public $bio;
    public $user;
    public $allDB;
    public $name;

    public function __construct(){
        $this->middleware(function ($request, $next) {
           if (!$this->element = Element::where('slug', $request->slug)->first()) {
               abort(404);
           }

           if (!$this->bio = User::where('id', $this->element->user)->first()) {
                abort(404);
           }
           
           // Verify workspace_id if element has one
           // Elements should only be accessible from their workspace context
           // If accessed via workspace route, verify it matches
           if ($this->element->workspace_id) {
               // Check if request has workspace context (from middleware Bio)
               $workspace = $request->attributes->get('workspace') ?? null;
               if ($workspace && $workspace->id != $this->element->workspace_id) {
                   // Element belongs to different workspace
                   abort(404);
               }
           }

           $this->allDB = Elementdb::where('element', $this->element->id)->orderBy('id', 'DESC')->get();

           $this->slug = $request->slug;

           $this->name = $this->element->element;

           return $next($request);
        });

        View::composer('*', function ($view){
            $bio = $this->bio;
            View::share('bio', $bio);
            View::share('element', $this->element);
            View::share('allDB', $this->allDB);
            View::share('ElemName', $this->name);
            $user = Auth::user();
            View::share('user', $user);
            View::share('sandy', $this);
        });
    }

    public function db(){
        $db = Elementdb::where('element', $this->element->id)->get();

        return $db;
    }


}