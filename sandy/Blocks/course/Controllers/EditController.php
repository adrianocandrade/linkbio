<?php

namespace Sandy\Blocks\course\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class EditController extends Controller{
    public $id;
    public $block;
    public $name = 'course';

    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
           $this->id = $request->id;
           $this->block = Block::where('id', $this->id)->where('block', $this->name)->where('user', $this->user->id)->first();


            // Check if exists
            if (!$this->block) {
                abort(404);
            }

            // Proceed
           return $next($request);
        });

    }
    public function skel($id, $element){
        $blocksElem = Blockselement::where('block_id', $this->block->id)->where('id', $element)->first();

        if (!$blocksElem) {
            abort(404);
        }

        return view("Blocks-$this->name::skel.edit-skel", ['wrapper' => $this->block, 'block' => $blocksElem]);
    }

    public function edit($id){
        $blocksElem = Blockselement::where('block_id', $this->block->id)
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();
        return view("Blocks-$this->name::edit", ['block' => $this->block, 'blocksElem' => $blocksElem]);
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