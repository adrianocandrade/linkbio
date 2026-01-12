<?php

namespace App\Models;

use App\Models\Base\Visitor as BaseVisitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

class Visitor extends BaseVisitor
{
	protected $fillable = [
		'user',
		'workspace_id',
		'slug',
		'session',
		'ip',
		'tracking',
		'views'
	];

	protected $casts = [
		'tracking' => 'array'
	];


	public function scopeGetInsight(Builder $query, $user){
        // Get Model
        $visitors = \App\Models\Visitor::where('user', $user->id)->get();

        // Empty array of visits
        $returned = [];


        // Get All Countries
        $countries = [];
        foreach ($visitors as $item) {
            $iso = (string) ao($item->tracking, 'country.iso');
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
            $iso = ao($item->tracking, 'country.iso');
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


        $start_of_year = \Carbon\Carbon::now()->startOfYear()->toDateString();
        $visitors_this_year = \App\Models\Visitor::where('user', $user->id)->where('created_at', '>=', $start_of_year)->get();


        // Get This Year Views
        $thisyear = [];
        foreach ($visitors_this_year as $item) {
            $date = (string) \Carbon\Carbon::parse($item->created_at)->format('M');
            if (!empty($date) && !array_key_exists($date, $thisyear)) {
                $thisyear[$date] = [
                    'visits' => 0,
                    'unique' => 0,
                ];
            }

            if (array_key_exists($date, $thisyear)) {
                $thisyear[$date]['unique']++;
                $thisyear[$date]['visits'] += $item->views;
            }
        }
        $thisyear = get_chart_data($thisyear);

        $returned = ['countries' => $countries, 'cities' => $state, 'devices' => $devices, 'browsers' => $browsers, 'getviews' => $getviews, 'thisyear' => $thisyear];


        return $returned;
	}

    public function scopeTopUsers(Builder $query){
        // Get Model
        $visitors = \App\Models\Visitor::get();

        // Empty array of visits
        $returned = [];

        // Loop Visitors
        foreach ($visitors as $item) {
            $id = $item->slug;

             if (empty($id)) {
                 if ($item->workspace_id) {
                     $ws = \App\Models\Workspace::find($item->workspace_id);
                     if ($ws) $id = $ws->slug;
                 } else {
                     $id = user('username', $item->user);
                 }
            }

            $id = (string) $id;
            if (!empty($id) && !array_key_exists($id, $returned)) {
                
                // Get Name and Avatar
                $name = user('name', $item->user);
                $avatar = user('avatar', $item->user);
                $bio = user('bio', $item->user);

                // Check if it is a workspace
                $workspace = \App\Models\Workspace::where('slug', $id)->first();
                if($workspace){
                    $name = $workspace->name;
                    $bio = $workspace->bio;
                    
                    if (!empty($workspace->avatar)) {
                        $avatar = getStorage('media/bio/avatar', $workspace->avatar);
                    } 
                }

                $returned[$id] = [
                    'visits' => 0,
                    'unique' => 0,
                    'user' => $item->user,
                    'slug' => $id,
                    'name' => $name,
                    'avatar' => $avatar,
                    'bio' => $bio,
                    'is_workspace' => $workspace ? true : false
                ];
            }

            if (array_key_exists($id, $returned)) {
                $returned[$id]['unique']++;
                $returned[$id]['visits'] += $item->views;
            }
        }

        usort($returned, function ($a, $b) {
            return $a['visits'] - $b['visits'];
        });
        $returned = array_reverse($returned);

        return $returned;
    }
}
