<?php

namespace Modules\Docs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Blog;
use App\Models\DocsCategory;
use App\Models\DocsGuide;

class DocsController extends Controller{
    public function index(Request $request){
        // Get query
        if (!empty($query = $request->get('query'))) {
            $docs = DocsGuide::where('status', 1)->where('name', 'LIKE','%'.$query.'%')->get();
            return view('docs::query', ['docs' => $docs]);
        }
        // Get all docs
        $getDocs = DocsCategory::get();
        // Docs array
        $docs = [];
        $guides = [];

        // Loop all the docs and get guides
        foreach ($getDocs as $item) {
            $guide = DocsGuide::where('docs_category', $item->id)->where('status', 1)->limit(5)->get();
            $guideCounts = DocsGuide::where('docs_category', $item->id)->where('status', 1)->count();

            $guides[$item->id]['guide'] = $guide;
            $guides[$item->id]['guideCounts'] = $guideCounts;

            $docs[$item->id] = $item;
        }

        // Return view
        return view('docs::index', ['docs' => $docs, 'guides' => $guides]);
    }
    public function guides($id){
        if (!$doc = DocsCategory::find($id)) {
            abort(404);
        }
        // View Docs Guide's
        $guides = DocsGuide::where('docs_category', $id)->where('status', 1)->get();

        return view('docs::guides', ['guides' => $guides, 'doc' => $doc]);
    }


    public function guide($slug){

        $guide = DocsGuide::where('slug', $slug)->where('status', 1)->first();

        if (!$guide) {
            abort(404);
        }

        $content = ao($guide->content, 'content');

        $details = [
            '{site}' => parse(config('app.url'), 'host'),
            '{server_ip}' => $_SERVER['SERVER_ADDR']
        ];
        $content = str_replace(array_keys($details), array_values($details), $content);

        return view('docs::guide', ['guide' => $guide, 'content' => $content]);
    }
}
