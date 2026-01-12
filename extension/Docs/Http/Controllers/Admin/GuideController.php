<?php

namespace Modules\Docs\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Blog;
use App\Models\DocsCategory;
use App\Models\DocsGuide;

class GuideController extends Controller{
    public $docs;

    function __construct(){
        $this->middleware(function ($request, $next) {
           $this->docs = DocsCategory::find($request->id);

           if (!$this->docs) {
             abort(404);
           }

           return $next($request);
        });


        View::composer('*', function ($view){
            View::share('docs', $this->docs);
        });
    }

    public function index(){
        // Return view
        return view('docs::admin.index');
    }


    public function create($id){
        $alldocs = DocsCategory::get();

        return view('docs::admin.guide.create', ['alldocs' => $alldocs]);
    }

    public function edit($id, $guide_id){
        $alldocs = DocsCategory::get();

        if (!$guide = DocsGuide::find($guide_id)) {
            abort(404);
        }

        return view('docs::admin.guide.edit', ['alldocs' => $alldocs, 'guide' => $guide]);
    }

    public function delete($id, $guide_id, Request $request){
        $docs = DocsGuide::find($guide_id);

        if (!$docs) {
            abort(404);
        }

        $docs->delete();


        return redirect()->route('admin-docs-view', $id)->with('success', __('Deleted Successfully'));
    }

    public function editPost($id, $guide_id, Request $request){
        // Validate request
        $request->validate([
            'name' => 'required',
            'short_des' => 'required',
            'docs' => 'required',
            'description' => 'required'
        ]);

        $docs = DocsGuide::find($guide_id);

        if (!$docs) {
            abort(404);
        }


        if ($banner = $this->processImage($request, 'banner', $docs->id)) {
            $media = [
                'banner' => $banner
            ];
            $docs->media = $media;
        }

        // Media array

        $content = [
            'subdes' => $request->short_des,
            'content' => $request->description
        ];

        //
        $docs->name = $request->name;
        //$docs->slug = $slugify;
        $docs->status = $request->status;
        $docs->docs_category = $request->docs;
        $docs->content = $content;
        $docs->save();

        // Return success

        return back()->with('success', __('Saved Successfully'));
    }

    public function createPost(Request $request){
        // Validate request

        $request->validate([
            'name' => 'required',
            'short_des' => 'required',
            'docs' => 'required',
            'description' => 'required'
        ]);

        // Convert Name To Slug
        $slugify = slugify($request->name);
        $rand = \Str::random(4);
        $slugify = "$slugify". "_" ."{$rand}";

        $banner = $this->processImage($request, 'banner', null);

        // Media array

        $media = [
            'banner' => $banner
        ];

        $content = [
            'subdes' => $request->short_des,
            'content' => $request->description
        ];

        //
        $docs = new DocsGuide;
        $docs->name = $request->name;
        $docs->slug = $slugify;
        $docs->status = $request->status;
        $docs->docs_category = $request->docs;
        $docs->content = $content;
        $docs->media = $media;
        $docs->save();

        // Return success

        return redirect()->route('admin-docs-view', $request->docs)->with('success', __('Saved Successfully'));
    }

    private function processImage($request, $input, $guide_id){

        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // If is new or remove image if exists

        if ($guide = DocsGuide::find($guide_id)) {
            $banner = ao($guide->media, 'banner');

            if (!empty($banner) && mediaExists('media/site/docs/guide', $banner)) {
                storageDelete('media/site/docs/guide', $banner); 
            }
        }

        // Image name
        $image = putStorage('media/site/docs/guide', $request->{$input});

        // Return image name
        return $image;
    }
}