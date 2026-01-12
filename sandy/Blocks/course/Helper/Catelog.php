<?php

namespace Sandy\Blocks\course\Helper;
use Illuminate\Http\File;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOption;

class Catelog{
    public static function catelog_item($item){


        return view('Blocks-course::bio.include.course-item', ['item' => $item]);
    }
}