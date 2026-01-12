<?php

namespace Sandy\Blocks\image\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;
use App\Models\Element;

class EditController extends Controller{
    public $id;
    public $block;

    public $name = 'image';

    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
           $this->id = $request->id;
           $this->block = Block::where('id', $this->id)->where('block', $this->name)->where('user', $this->user->id)->first();

            // Proceed
           return $next($request);
        });
    }

    public function skel($id){
        $blocksElem = Blockselement::where('id', $id)->where('user', $this->user->id)->first();

        if (!$blocksElem) {
            abort(404);
        }

        $block = Block::where('id', $blocksElem->block_id)->where('block', $this->name)->where('user', $this->user->id)->first();
        if (!$block) {
            abort(404);
        }

        return view("Blocks-$this->name::edit", ['wrapper' => $block, 'block' => $blocksElem]);
    }

    public function sort($id, Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = Blockselement::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }
}