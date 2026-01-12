<?php

namespace Sandy\Segment\email\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Models\Elementdb;

class ExportController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function export($slug){
        $slug = \Str::random(3);
        $fileName = "email-list-$slug.csv";
        $tasks = Elementdb::where('element', $this->element->id)->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['email', 'first_name', 'last_name'];

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($tasks as $task) {
                fputcsv($file, [ao($task->database, 'email'), ao($task->database, 'first_name'), ao($task->database, 'last_name')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}