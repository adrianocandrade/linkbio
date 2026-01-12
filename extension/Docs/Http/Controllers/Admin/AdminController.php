<?php

namespace Modules\Docs\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Blog;
use App\Models\DocsCategory;
use App\Models\DocsGuide;

class AdminController extends Controller{
    public function index(){
        // Get all docs
        $getDocs = DocsCategory::get();
        // Docs array
        $docs = [];
        $guides = [];

        // Loop all the docs and get guides
        foreach ($getDocs as $item) {
            $guide = DocsGuide::where('docs_category', $item->id)->limit(5)->get();
            $guideCounts = DocsGuide::where('docs_category', $item->id)->count();

            $guides[$item->id]['guide'] = $guide;
            $guides[$item->id]['guideCounts'] = $guideCounts;

            $docs[$item->id] = $item;
        }
        // Return view
        return view('docs::admin.index', ['docs' => $docs, 'guides' => $guides]);
    }


    public function create(){
        // Get Docs

        return view('docs::admin.create', []);
    }


    public function edit($id){
        // Get Docs
        if (!$docs = DocsCategory::find($id)) {
            abort(404);
        }

        return view('docs::admin.edit', ['docs' => $docs]);
    }

    public function editPost($id, Request $request){
        if (!$doc = DocsCategory::find($id)) {
            abort(404);
        }


        $doc->name = $request->name;
        $doc->save();

        // Return Success
        return back()->with('success', __('Saved Successfully'));
    }

    public function delete($id){
        if (!$doc = DocsCategory::find($id)) {
            abort(404);
        }

        // Delete Guides

        $guides = DocsGuide::where('docs_category', $doc->id)->delete();

        $doc->delete();

        return back()->with('success', __('Deleted Successfully'));
    }

    public function view($id){
        if (!$doc = DocsCategory::find($id)) {
            abort(404);
        }

        // View Docs Guide's
        $guides = DocsGuide::where('docs_category', $id)->get();


        return view('docs::admin.view', ['guides' => $guides, 'doc' => $doc]);
    }

    public function createPost(Request $request){
        // Validate request

        $request->validate([
            'name' => 'required'
        ]);

        $slugify = slugify($request->name);
        $rand = \Str::random(4);
        $slugify = "$slugify". "_" ."{$rand}";

        //
        $docs = new DocsCategory;
        $docs->name = $request->name;
        $docs->slug = $slugify;
        $docs->save();

        // Return success

        return redirect()->route('admin-docs-index')->with('success', __('Saved Successfully'));
    }
}