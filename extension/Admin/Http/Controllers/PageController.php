<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Page;

class PageController extends Controller{
    public function pages(Page $page){
        $pages = $page
                ->orderBy('id', 'DESC')->get();

        return view('admin::page.all', ['pages' => $pages]);
    }

    public function edit($id, Page $page){

        if (!$page = $page->find($id)) {
            abort(404);
        }


        return view('admin::page.edit', ['page' => $page]);
    }

    public function editPage($id, Request $request, Page $page){
        
        if (!$page = $page->find($id)) {
            abort(404);
        }

        // Process image upload
        if ($thumbnail = $this->processImage($request, 'page_thumbnail', $page->id)) {
            $page->thumbnail = $thumbnail;
        }

        // Validate request
        $request->validate([
            'name' => 'required|min:2',
            'author' => 'required',
            'ttr' => 'required',
            'location' => 'required|unique:pages,location,' . $page->id,
        ]);

        // Make Page location/slug into a useable slug. Replace spaces with _
        $location = slugify($request->location, '-');

        // Check if Page uri type is external
        if ($request->type == 'external') {
            $location = $request->location;
        }

        // Post Page to db
        $page->name = $request->name;
        $page->status = $request->status;
        $page->type = $request->type;
        $page->location = $location;
        $page->description = $request->description;
        $page->author = $request->author;
        $page->ttr = $request->ttr;

        $page->save();

        return back()->with('success', __('Save Successfully'));
    }

    public function new(){

        return view('admin::page.new');
    }

    public function newPage(Request $request, Page $page){
        // Get current user
        $user = \Auth::user();
        // Process image upload

        $thumbnail = $this->processImage($request, 'page_thumbnail', null);

        // Validate request

        $request->validate([
            'name' => 'required|min:2',
            'author' => 'required',
            'ttr' => 'required',
            'location' => 'required|unique:blog,location',
        ]);

        // Make Page location/slug into a useable slug. Replace spaces with _
        $location = slugify($request->location, '_');

        // Check if Page uri type is external
        if ($request->type == 'external') {
            $location = $request->location;
        }

        // Post Page to db
        $page->name = $request->name;
        $page->status = $request->status;
        $page->postedBy = $user->id;
        $page->type = $request->type;
        $page->thumbnail = $thumbnail;
        $page->location = $location;
        $page->description = $request->description;
        $page->author = $request->author;
        $page->ttr = $request->ttr;
        $page->save();


        // return back

        return redirect()->route('admin-pages')->with('success', __('Save Successfully'));
    }

    public function delete($id){
        if (!$page = Page::find($id)) {
            abort(404);
        }

        // Unset Images
        if (!empty($page->thumbnail) && mediaExists('media/site/page', $page->thumbnail)) {
            storageDelete('media/site/page', $page->thumbnail); 
        }


        // Delete Page
        $page->delete();

        // Return back
        return back()->with('success', __('Deleted Successfully'));
    }

    public function sort(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = Page::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }

    private function processImage($request, $input, $page_id){

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

        if ($page = Page::find($page_id)) {
            if (!empty($page->thumbnail) && mediaExists('media/site/page', $page->thumbnail)) {
                storageDelete('media/site/page', $page->thumbnail); 
            }
        }

        // Image name
        $image = putStorage('media/site/page', $request->{$input});

        // Return image name
        return $image;
    }
}
