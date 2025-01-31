<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Retrieves user data by country and status, and returns a view with the data.
     *
     * This method joins the `users` and `addresses` tables to get the user count by country,
     * and also retrieves the user count by status. The data is then passed to the
     * `admin.dashboard` view.
     *
     * @return \Illuminate\View\View
     */
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
