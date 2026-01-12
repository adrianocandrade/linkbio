<?php

namespace Sandy\Plugins\user_util\Controllers\Theme;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;

class ThemesController extends Controller{
    public function all(){
        return view('Plugin-user_util::theme.all');
    }

    public function upload(Request $request){
        // Validate the request
        $request->validate([
            'archive' => 'required|file|mimes:zip',
        ]);

        // Folder location
        $location = \BioStyle::path();

        $archiveName = $request->file('archive')->getClientOriginalName();

        $theme = pathinfo($archiveName, PATHINFO_FILENAME);

        if (\File::exists("$location/$theme")) {
            return back()->with('error', __('A theme with the same name already exists'));
        }

        // Move to folder
        
        $request->archive->move($location, $archiveName);

        // Unzip the file
        try {
            $zipper = new \Madnest\Madzipper\Madzipper;
            $zipper->make("$location/$archiveName")->extractTo("$location");
            $zipper->close();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // Unlink the file
        unlink("$location/$archiveName");

        \BioStyle::makePublic($theme);
        //
        return redirect()->route('sandy-plugins-user_util-themes-index')->with('success', __('Theme uploaded successfully.'));
    }

    public function delete($theme, Request $request){
        $location = \BioStyle::getdir($theme);
        if (!\BioStyle::has($theme)) {
            abort(404);
        }

        storageDeleteDir($dir = "assets/image/theme/$theme");

        //

        try {
            \File::deleteDirectory($location);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('sandy-plugins-user_util-themes-index')->with('success', __('Theme deleted successfully.'));
    }
}