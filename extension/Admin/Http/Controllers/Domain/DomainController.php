<?php

namespace Modules\Admin\Http\Controllers\Domain;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Domain;

class DomainController extends Controller{
    public function all(Request $request){
        $domains = Domain::orderBy(\DB::raw('user IS NULL'), 'DESC');

        if (!empty($query = $request->get('query'))) {
            $domains = $domains->where('host', 'LIKE','%'.$query.'%');
        }

        $domains = $domains->get();

        return view('admin::domain.index', ['domains' => $domains]);
    }


    public function post($type, Request $request){
        if (!in_array($type, ['new', 'edit', 'delete'])) {
            abort(404);
        }



        switch ($type) {
            case 'new':
                if (Domain::where('host', $request->host)->first()) {
                    return back()->with('error', __('The entered host name ":domain" already exists.', ['domain' => $request->host]));
                }

                $request->validate([
                    'host' => 'required'
                ]);


                $valid_url = "$request->protocol://$request->host";
                if (!validate_url(strtolower($valid_url))) {
                    return back()->with('error', __('Domain is not valid'));
                }

                $domain = new Domain;
                $domain->host = $request->host;
                $domain->scheme = $request->protocol;
                $domain->save();


                return back()->with('success', __('Domain added successfully.'));
            break;

            case 'edit':
                if (!$domain = Domain::where('id', $request->id)->first()) {
                    abort(404);
                }

                if (Domain::where('host', $request->host)->where('id', '!=', $request->id)->first()) {
                    return back()->with('error', __('The entered host name ":domain" already exists.', ['domain' => $request->host]));
                }



                $domain->host = $request->host;
                $domain->scheme = $request->protocol;
                $domain->update();

                return back()->with('success', __('Domain updated successfully.'));
            break;


            case 'delete':
                if (!$domain = Domain::where('id', $request->id)->first()) {
                    abort(404);
                }

                $domain->delete();
                return back()->with('success', __('Domain deleted successfully.'));
            break;
        }


        return back()->with('error', __('Undefined Method'));
    }
}
