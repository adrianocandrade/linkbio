<?php

namespace App\Models;

use App\Models\Base\Highlight as BaseHighlight;

class Highlight extends BaseHighlight
{
	protected $fillable = [
		'user',
		'workspace_id',
		'thumbnail',
		'is_element',
		'element',
		'link',
		'content',
		'position'
	];

	protected $casts = [
		'thumbnail' => 'array',
		'content'	=> 'array'
	];

    public function workspace() {
        return $this->belongsTo('App\Models\Workspace', 'workspace_id');
    }


    public static function elem_or_linkonly($id, $user){
        $highlight = \App\Models\Highlight::find($id);

        //
        if (!$highlight) {
            return false;
        }


        $link = linker($highlight->link, $user);
        if ($highlight->is_element) {
            if ($element = \App\Models\Element::find($highlight->element)) {
                $link = route("sandy-app-$element->element-render", $element->slug);
            }
        }



        return $link;
    }

    public static function elemOrLink($id, $user){
        $highlight = \App\Models\Highlight::find($id);

        //
        if (!$highlight) {
            return false;
        }


        $link = linker($highlight->link, $user);
        $html = "href=\"$link\" app-sandy-prevent=\"\" target=\"_blank\" ";

        if ($highlight->is_element) {
            if ($element = \App\Models\Element::find($highlight->element)) {
                // This is our element

                if (\Route::has("sandy-app-$element->element-render")) {
                    $link = route("sandy-app-$element->element-render", $element->slug);

                    $html = "href=\"$link\" app-sandy-prevent=\"\"";
                }
            }
        }



        return $html;
    }
}
