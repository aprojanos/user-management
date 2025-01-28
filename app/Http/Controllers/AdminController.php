<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $usersByCountry = User::join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('countries', 'countries.code', '=', 'addresses.country_code')
            ->select('countries.name as country', DB::raw('count(*) as total'))
            ->groupBy('country')
            // ->havingRaw('total > 2')
            ->get();
        $usersByStatus = User::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', [
            'usersByCountry' => $usersByCountry,
            'usersByStatus' => $usersByStatus,
        ]);
    }

}
