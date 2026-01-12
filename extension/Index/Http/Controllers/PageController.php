<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Page;

class PageController extends Controller{
    public function pages(Request $request){
        // Get Blog's
        $pages = Page::where('status', 1)
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC');


        // Get query
        if (!empty($query = $request->get('query'))) {
            $pages->where('name', 'LIKE','%'.$query.'%');
        }

        // Get blog's
        $pages = $pages->get();

        // Get most read
        $most3Read = $this->getMostRead();
        $mostRead = $this->getMostRead(1);

        // Return view
        return view('index::page.index', ['pages' => $pages, 'most3Read' => $most3Read, 'mostRead' => $mostRead]);
    }

    public function single($uri, Request $request){
        // Get This Blog
        $page = Page::where('status', 1)->where('type', 'internal')->where('location', $uri)->first();

        // Check if blog exists
        if (!$page) {
            abort(404);
        }

        // Add visits
        $this->track($page->id, $request);

        // Get Most Read
        $most3Read = $this->getMostRead();

        // Return view
        return view('index::page.single', ['page' => $page, 'most3Read' => $most3Read]);
    }

    public function getMostRead($limit = 3){
        $views = 4;

        // Get Most Read
        $most = Page::where('status', 1)->orderBy('total_views', 'DESC')->limit($limit)->get();

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
        $page = Page::find($id);

        // Check if blog exists

        if (!$page) {
            return false;
        }

        // Define session
        $session  = $request->session();
        // Check if visits exisits in session and preceed
        if (empty($session->get('page_visit_' . $page->id))) {
            // Update current page with new page visits
            $page->total_views = ($page->total_views + 1);
            $page->save();
        }
        // Add visits to session
        $session->put('page_visit_' . $page->id, 'true');
    }
}
