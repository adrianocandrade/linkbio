<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Page;
use App\User;

class SitemapController extends Controller
{
    public function index()
    {
        // Fetch active blogs
        $blogs = Blog::where('status', 1)->orderBy('updated_at', 'desc')->get();

        // Fetch active pages
        $pages = Page::where('status', 1)->orderBy('updated_at', 'desc')->get();

        // Fetch active/public users (Profiles)
        // Assuming status 1 is active. 
        // Note: For large datasets, chunking is recommended, but for now this suffices.
        $users = User::where('status', 1)->orderBy('updated_at', 'desc')->get();

        return response()->view('index::sitemap', [
            'blogs' => $blogs,
            'pages' => $pages,
            'users' => $users,
        ])->header('Content-Type', 'text/xml');
    }
}
