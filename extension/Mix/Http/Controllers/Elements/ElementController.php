<?php

namespace Modules\Mix\Http\Controllers\Elements;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Element;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use App\Elements;

class ElementController extends Controller{
    public function all(){
        $workspaceId = session('active_workspace_id');
        $elementsQuery = Element::where('user', $this->user->id);
        
        if ($workspaceId) {
            $elementsQuery->where('workspace_id', $workspaceId);
        }
        
        $elements = $elementsQuery->orderBy('id', 'DESC')->get();
        return view('mix::elements.all', ['elements' => $elements]);
    }

    public function preview_section($element){
        if (!Elements::has($element)) {
            abort(404);
        }

        $config = function($key = null) use ($element){
            return Elements::config($element, $key);
        };


        return view('mix::elements.preview', ['element' => $element, 'config' => $config]);
    }


    public function elementTree($slug){
        $workspaceId = session('active_workspace_id');
        $itemQuery = Element::where('slug', $slug)->where('user', $this->user->id);
        
        if ($workspaceId) {
            $itemQuery->where('workspace_id', $workspaceId);
        }
        
        $item = $itemQuery->first();

        if (!$item) {
            return fancy_error(__('Common Error'), __('Element not found. Please try again.'));
        }

        if (!Elements::has($element = $item->element)) {
            abort(404);
        }

        $config = function($key = null) use ($element){
            return Elements::config($element, $key);
        };


        return view('mix::elements.tree', ['element' => $element, 'config' => $config, 'item' => $item]);
    }
}
