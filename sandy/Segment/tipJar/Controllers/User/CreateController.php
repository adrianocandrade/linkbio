<?php

namespace Sandy\Segment\tipJar\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'tipJar';
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function create(){
        return view("App-$this->element::create");
    }

    public function createPost(Request $request){
        $request->validate([
            'label' => 'required',
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }


        $amounts = [];

        if (!empty($request->amounts)) {
            foreach ($request->amounts as $key => $value) {
                $validator = \Validator::make(['price' => ao($value, 'price')], ['price' => 'min:1|required|numeric']);


                $validator->validate();

                $amounts[$key] = $value;
            }
        }
        $content['amounts'] = $amounts;


        $extra = [
            'name' => $request->label
        ];

        $insert = insertElement($this->user->id, $this->element, $content, $extra);

        // Create Element
        $data = [
            'element' => [
                'content' => [
                    'heading' => $request->label
                ],

                'is_element' => true,
                'element' => ao($insert, 'element_id'),
            ]
        ];


        \Blocks::create_block_sections($this->user->id, 'links', $data);

        // Return to elements
        return redirect()->route('user-mix')->with('success', __('Saved Successfully'));
    }
}