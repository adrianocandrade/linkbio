<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Page;
use App\User;

use App\Models\DocsCategory;
use App\Models\DocsGuide;

class SitemapController extends Controller
{
    public function index()
    {
        // Fetch active blogs
        $blogs = Blog::where('status', 1)->orderBy('updated_at', 'desc')->get();

        // Fetch active pages
        $pages = Page::where('status', 1)->orderBy('updated_at', 'desc')->get();

        // Fetch active/public users (Profiles)
        $users = User::where('status', 1)->orderBy('updated_at', 'desc')->get();

        // Fetch Docs Categories (Routes: docs/guides/{id})
        // Assuming there isn't a specific 'status' column for categories based on listing, but usually safe to check if it exists.
        $docCategories = DocsCategory::all(); 

        // Fetch Docs Guides (Routes: docs/guide/{slug})
        $docGuides = DocsGuide::where('status', 1)->orderBy('updated_at', 'desc')->get();

        return response()->view('index::sitemap', [
            'blogs' => $blogs,
            'pages' => $pages,
            'users' => $users,
            'docCategories' => $docCategories,
            'docGuides' => $docGuides,
        ])->header('Content-Type', 'text/xml');
    }
}
