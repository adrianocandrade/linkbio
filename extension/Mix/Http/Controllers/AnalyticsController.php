<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\MySession;
use App\Models\Visitor;
use App\Models\Linkertrack;

class AnalyticsController extends Controller{
    public function insight(Request $request){
        // Get All Visitos
        $visitors = $this->getAllVisitorsStats();

        // ALso get live visits
        $live = $this->getLiveVists();

        // Get Top Links

        $topLinks = Linkertrack::topLink($this->user, 5);


        // Get Links visits
        $linksVisit = Linkertrack::totalVisits($this->user);
        // Return view
        return view('mix::analytics.insight', ['live' => $live, 'linksVisit' => $linksVisit, 'topLinks' => $topLinks, 'visitors' => $visitors]);
    }

    public function links(){
        // Get all links insight
        $links = Linkertrack::topLink($this->user, null);

        // Get Links visits
        $linksVisit = Linkertrack::totalVisits($this->user);

        // Return the view
        return view('mix::analytics.section.links', ['links' => $links, 'linksVisit' => $linksVisit]);
    }

    public function link($slug){
        if (!Linkertrack::where('user', $this->user->id)->where('slug', $slug)->first()) {
            abort(404);
        }
        // Get link insight
        $link = Linkertrack::getLinkInsight($slug, $this->user);

        // Return the view
        return view('mix::analytics.section.link', ['link' => $link]);
    }

    public function views(){
        // Get Model Visitors
        $visitors = $this->getAllVisitorsStats();


        // Return the view
        return view('mix::analytics.section.view', ['visitors' => $visitors]);
    }

    public function live(){
        // Get live vistors
        $visitors = MySession::getInsight($this->user);


        // ALso get live visits
        $live = MySession::activity(10)->hasBio($this->user->id)->get();

        // Return the view
        return view('mix::analytics.section.live', ['visitors' => $visitors, 'live' => $live]);
    }

    private function getLiveVists(){
        $live = MySession::activity(10)->hasBio($this->user->id)->limit(5)->get();

        // Return Live Visits
        return $live;
    }


    private function getAllVisitorsStats(){
        return Visitor::getInsight($this->user);
    }
}
