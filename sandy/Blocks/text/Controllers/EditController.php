<?php

namespace Sandy\Blocks\text\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;

class EditController extends Controller{
    public $id;
    public $block;

    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
           $this->id = $request->id;
           $this->block = Block::where('id', $this->id)->where('block', 'text')->where('user', $this->user->id)->first();


            // Check if exists
            if (!$this->block) {
                abort(404);
            }

            // Proceed
           return $next($request);
        });

    }
    public function edit($id){
        return view('Blocks-text::edit', ['block' => $this->block]);
    }

    public function EditPost($id, Request $request){
        $blocks = ['heading' => $request->heading, 'content' => $request->content];
        $block = Block::find($this->id);
        $block->blocks = $blocks;
        $block->save();

        return back()->with('success', __('Saved Successfully'));

    }
}