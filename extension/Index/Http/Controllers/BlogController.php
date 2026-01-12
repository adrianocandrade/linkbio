<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Blog;

class BlogController extends Controller{
    public function blogs(Request $request){
        // Get Blog's
        $blogs = Blog::where('status', 1)
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC');


        // Get query
        if (!empty($query = $request->get('query'))) {
            $blogs->where('name', 'LIKE','%'.$query.'%');
        }

        // Get blog's
        $blogs = $blogs->get();

        // Get most read
        $most3Read = $this->getMostRead();
        $mostRead = $this->getMostRead(1);

        // Return view
        return view('index::blog.index', ['blogs' => $blogs, 'most3Read' => $most3Read, 'mostRead' => $mostRead]);
    }

    public function single($uri, Request $request){
        // Get This Blog
        $blog = Blog::where('status', 1)->where('type', 'internal')->where('location', $uri)->first();

        // Check if blog exists
        if (!$blog) {
            abort(404);
        }

        // Add visits
        $this->track($blog->id, $request);

        // Get Most Read
        $most3Read = $this->getMostRead();

        // Return view
        return view('index::blog.single', ['blog' => $blog, 'most3Read' => $most3Read]);
    }

    public function getMostRead($limit = 3){
        $views = 4;

        // Get Most Read
        $most = Blog::where('status', 1)->orderBy('total_views', 'DESC')->limit($limit)->get();

        // Returnable item
        $return = [];


        // Loop & check if the views is more than 10
        foreach ($most as $item) {
            if ($item->total_views > $views) {
                $return[] = $item;
            }
        }


        // Return most read
        return $return;
    }

    public function track($id, $request){
        // Get Blog
        $blog = Blog::find($id);

        // Check if blog exists

        if (!$blog) {
            return false;
        }

        // Define session
        $session  = $request->session();
        // Check if visits exisits in session and preceed
        if (empty($session->get('blog_visit_' . $blog->id))) {
            // Update current page with new page visits
            $blog->total_views = ($blog->total_views + 1);
            $blog->save();
        }
        // Add visits to session
        $session->put('blog_visit_' . $blog->id, 'true');
    }
}
