<?php

namespace App\Models;

use App\Models\Base\Linkertrack as BaseLinkertrack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

class Linkertrack extends BaseLinkertrack
{
    protected $table = 'linker_track';

	protected $fillable = [
		'linker',
		'user',
		'session',
		'link',
		'ip',
		'tracking',
		'views'
	];

	protected $casts = [
		'tracking' => 'array',
	];

    public function scopeTopLink(Builder $query, $user, $limit = 5){
    	$model = new \App\Models\Linkertrack;
		
		$log = [];

		$totalVisits = 0;
    	// 

    	foreach ($model->where('user', $user->id)->get() as $item) {
            if(!array_key_exists($item->slug, $log)) {
                $log[$item->slug] = [
                    'visits' => 0,
                    'unique' => 0,
                    'link' => $item->link,
                ];
            }

            if (array_key_exists($item->slug, $log)) {
	            $log[$item->slug]['unique']++;
	            $log[$item->slug]['visits'] += $item->views;

	            $totalVisits = ($totalVisits + $item->views);
            }
    	}

    	$col = array_column( $log, "visits" );
    	array_multisort( $col, SORT_DESC, $log );

    	$log = array_slice($log, 0, $limit);

    	return $log;
    }
    public function scopeTotalVisits(Builder $query, $user){
    	$model = new \App\Models\Linkertrack;
		
		$log = [];

		$visits = 0;
		$unique = 0;
    	// 

    	foreach ($model->where('user', $user->id)->get() as $item) {
    		$unique++;
    		$visits += $item->views;
    	}

    	$log = ['visits' => $visits, 'unique' => $unique];

    	return $log;
    }


	public function scopeGetLinkInsight(Builder $query, $slug, $user){
        // Get Model
        $visitors = \App\Models\Linkertrack::where('slug', $slug)->where('user', $user->id)->get();

        // Empty array of visits
        $returned = [];


        // Get All Countries
        $countries = [];
        foreach ($visitors as $item) {
            $iso = ao($item->tracking, 'country.iso');
            $name = ao($item->tracking, 'country.name');

            if (!empty($iso) && !array_key_exists($iso, $countries)) {
                $countries[$iso] = [
                    'visits' => 0,
                    'unique' => 0,
                    'name' => $name,
                ];
            }

            if (array_key_exists($iso, $countries)) {
                $countries[$iso]['unique']++;
                $countries[$iso]['visits'] += $item->views;
            }
        }

        // Get ALL State

        $state = [];
        foreach ($visitors as $item) {
            $city = (string) ao($item->tracking, 'country.city');
            $iso = (string) ao($item->tracking, 'country.iso');
            $iso = strtoupper($iso);

            $check = "$city, $iso";

            if (!empty($city) && !array_key_exists($check, $state)) {
                $state[$check] = [
                    'visits' => 0,
                    'unique' => 0,
                    'name' => $city,
                    'iso' => $iso,
                ];
            }

            if (array_key_exists($check, $state)) {
                $state[$check]['unique']++;
                $state[$check]['visits'] += $item->views;
            }
        }

        // Get ALL Devices
        $devices = [];
        foreach ($visitors as $item) {
            $os = (string) ao($item->tracking, 'agent.os');
            if (!empty($os) && !array_key_exists($os, $devices)) {
                $devices[$os] = [
                    'visits' => 0,
                    'unique' => 0,
                    'name' => $os,
                ];
            }

            if (array_key_exists($os, $devices)) {
                $devices[$os]['unique']++;
                $devices[$os]['visits'] += $item->views;
            }
        }

        // Get AlL Browser
        $browsers = [];
        foreach ($visitors as $item) {
            $browser = (string) ao($item->tracking, 'agent.browser');
            if (!empty($browser) && !array_key_exists($browser, $browsers)) {
                $browsers[$browser] = [
                    'visits' => 0,
                    'unique' => 0,
                    'name' => $browser,
                ];
            }

            if (array_key_exists($browser, $browsers)) {
                $browsers[$browser]['unique']++;
                $browsers[$browser]['visits'] += $item->views;
            }
        }

        // Views
        $getviews = [];
        $views = 0;
        $unique = 0;
        foreach ($visitors as $item) {
            $unique++;
            $views += $item->views;
        }

        $getviews = [
            'visits' => $views,
            'unique' => $unique,
        ];


        $returned = ['countries' => $countries, 'cities' => $state, 'devices' => $devices, 'browsers' => $browsers, 'getviews' => $getviews];


        return $returned;
	}

    public function scopeTrack(Builder $query, $linker, $slug, $link, $user){
        $ip = getIp(); //getIp() or 102.89.2.139 for test

        $agent = new \Jenssegers\Agent\Agent;
        $iso_code = geoCountry($ip, 'country.iso_code');
        $iso_code = strtolower($iso_code);
        $country = geoCountry($ip, 'country.names.en');
        $city = geoCity($ip, 'city.names.en');

        $tracking = ['country' => ['iso' => $iso_code, 'name' => $country, 'city' => $city], 'agent' => ['browser' => $agent->browser(), 'os' => $agent->platform()]];


        // Track Visits
        if ($vistor = \App\Models\Linkertrack::where('session', Session::getId())->where('slug', $slug)->first()) {
            $vistor = \App\Models\Linkertrack::find($vistor->id);
            $vistor->views = ($vistor->views + 1);
            $vistor->save();
        }else{
            $new = new \App\Models\Linkertrack;
            $new->user = $user;
            $new->session = Session::getId();
            $new->linker = $linker;
            $new->link = $link;
            $new->slug = $slug;
            $new->ip = $ip;
            $new->tracking = $tracking;
            $new->views = 1;
            $new->save();
        }
    }
}
