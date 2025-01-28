<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $request): View {
        $allAddresses = Address::join('users', 'users.id', '=', 'addresses.user_id')
            ->join('countries', 'countries.code', '=', 'addresses.country_code')
            ->whereRaw('addresses.latitude is not null and addresses.longitude is not null')
            ->select('addresses.latitude', 'addresses.longitude', 'addresses.city', 'countries.name as country_name', 'users.name as user_name')
            ->get();

        $geoJson = ['type' => 'FeatureCollection', 'features' => $allAddresses->map(function ($feature) {
            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$feature->longitude, $feature->latitude]
                ],
                'properties' => [
                    'city' => $feature->city,
                    'country' => $feature->country_name,
                    'user' => $feature->user_name
                ]
            ];
        })];
        
        return view('index', ['geoJson' => $geoJson]);
    }
    
}
