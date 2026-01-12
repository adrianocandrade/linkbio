<?php

namespace Sandy\Blocks\course\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\course\Models\Course;
use Sandy\Blocks\course\Traits\Courses;

class CourseController extends Controller{
    use Courses;

    public function index(Request $request){
        $workspaceId = session('active_workspace_id');
        
        if (!$workspaceId) {
            // Fallback to default workspace
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }
        
        if (!$workspaceId) {
            abort(403, 'No valid workspace found');
        }
        
        $courses = Course::where('workspace_id', $workspaceId)->get();
        $analytics = $this->sales_analytics($request);

        return view('Blocks-course::mix.index', ['courses' => $courses, 'analytics' => $analytics]);
    }
}
