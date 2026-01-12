<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Blog;

class BlogController extends Controller{
    public function blogs(Blog $blog){
        $blogs = $blog
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')->get();

        return view('admin::blog.all', ['blogs' => $blogs]);
    }

    public function edit($id, Blog $blog){

        if (!$blog = $blog->find($id)) {
            abort(404);
        }


        return view('admin::blog.edit', ['blog' => $blog]);
    }

    public function editPost($id, Request $request, Blog $blog){
        if (!$blog = $blog->find($id)) {
            abort(404);
        }

        // Process image upload
        if ($thumbnail = $this->processImage($request, 'blog_thumbnail', $blog->id)) {
            $blog->thumbnail = $thumbnail;
        }

        // Validate request

        $request->validate([
            'name' => 'required|min:2',
            'author' => 'required',
            'ttr' => 'required',
            'location' => 'required|unique:blog,location,' . $blog->id,
        ]);

        // Make blog location/slug into a useable slug. Replace spaces with _
        $location = slugify($request->location, '_');

        // Check if blog uri type is external
        if ($request->type == 'external') {
            $location = $request->location;
        }

        // Post blog to db
        $blog->name = $request->name;
        $blog->status = $request->status;
        $blog->type = $request->type;
        $blog->location = $location;
        $blog->description = $request->description;
        $blog->author = $request->author;
        $blog->ttr = $request->ttr;
        $blog->save();


        // return back

        return back()->with('success', __('Save Successfully'));
    }

    public function new(){

        return view('admin::blog.new');
    }

    public function newPost(Request $request, Blog $blog){
        // Get current user
        $user = \Auth::user();
        // Process image upload

        $thumbnail = $this->processImage($request, 'blog_thumbnail', null);

        // Validate request

        $request->validate([
            'name' => 'required|min:2',
            'author' => 'required',
            'ttr' => 'required',
            'location' => 'required|unique:blog,location',
        ]);

        // Make blog location/slug into a useable slug. Replace spaces with _
        $location = slugify($request->location, '_');

        // Check if blog uri type is external
        if ($request->type == 'external') {
            $location = $request->location;
        }

        // Post blog to db
        $blog->name = $request->name;
        $blog->status = $request->status;
        $blog->postedBy = $user->id;
        $blog->type = $request->type;
        $blog->thumbnail = $thumbnail;
        $blog->location = $location;
        $blog->description = $request->description;
        $blog->author = $request->author;
        $blog->ttr = $request->ttr;
        $blog->save();


        // return back

        return redirect()->route('admin-blogs')->with('success', __('Save Successfully'));
    }

    public function delete($id){
        if (!$blog = Blog::find($id)) {
            abort(404);
        }

        // Unset Images
        if (!empty($blog->thumbnail) && mediaExists('media/site/blog', $blog->thumbnail)) {
            storageDelete('media/site/blog', $blog->thumbnail); 
        }


        // Delete blog
        $blog->delete();

        // Return back
        return back()->with('success', __('Deleted Successfully'));
    }

    public function sort(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = Blog::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }

    private function processImage($request, $input, $blog_id){

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

        if ($blog = Blog::find($blog_id)) {
            if (!empty($blog->thumbnail) && mediaExists('media/site/blog', $blog->thumbnail)) {
                storageDelete('media/site/blog', $blog->thumbnail); 
            }
        }

        // Image name
        $image = putStorage('media/site/blog', $request->{$input});

        // Return image name
        return $image;
    }
}
