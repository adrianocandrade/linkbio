<?php

namespace Sandy\Segment\embed_links\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function edit($slug){
        $skeleton = $this->video_skel();
        return view("App-$this->name::edit", ['skeleton' => $skeleton]);
    }

    public function editPost(Request $request){
        $request->validate([
            'label' => 'required',
            'content.link' => 'required'
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        $content['is_iframe'] = $this->isIframe(ao($content, 'type'));
        $content['thumbnail'] = getVideoBlocksThumbnail(ao($content, 'type'), ao($content, 'link'));

        $content['link'] = addsitescheme(ao($content, 'link'));

        $extra = [
            'name' => $request->label
        ];

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }



    private function isIframe($stream){
        $skeleton = $this->video_skel();

        return ao($skeleton, "$stream.isIframe");
    }


    private function video_skel(){
        return [
            'youtube' => [
                'icon' => 'sni sni-youtube',
                'color' => '#ff0000',
                'name' => 'Youtube',
                'placeholder' => 'https://youtu.be/wVrH_IUx74s',
                'isIframe' => false
            ],
            'vimeo' => [
                'icon' => 'sni sni-vimeo',
                'color' => '#1ab7ea',
                'name' => 'Vimeo',
                'placeholder' => 'https://vimeo.com/23423rwefse',
                'isIframe' => false
            ],
            'dailymotion' => [
                'svg' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="416 207.4 400 400"
             style="enable-background:new 416 207.4 400 400;" xml:space="preserve"> <path style="fill: #fff" class="st1" d="M653.5,308.2v68.1c-10.5-13.4-25-19.8-43.9-19.8c-19.8,0-37.5,7.3-52.1,21.5c-16.3,15.7-25,35.8-25,58.2 c0,24.4,9.3,45.4,27.3,61.4c13.7,12.2,30,18.3,48.9,18.3c18.6,0,32.6-4.9,46.3-18.3v17.5h44.5v-8.5h0V389v-10.6v-79.7L653.5,308.2z
             M618.9,474.4c-23.6,0-40.4-16.6-40.4-38.4c0-20.9,16.9-38.7,38.7-38.7c21.5,0,38.1,16.9,38.1,39.3
            C655.3,458.1,638.7,474.4,618.9,474.4z"/></svg>',
                'color' => '#000',
                'name' => 'Daily Motion',
                'placeholder' => 'https://www.dailymotion.com/video/x82jkc5',
                'isIframe' => false
            ],
            'others' => [
                'icon' => 'sni sni-dashboard',
                'color' => '#bbb',
                'name' => 'Others',
                'placeholder' => 'https://www.example.com',
                'isIframe' => true
            ],
        ];
    }
}