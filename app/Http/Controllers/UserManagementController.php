<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AddressType;
use App\Models\Country;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);
        $totalUsers = User::count();

        return view('admin.user-management.index', compact('users', 'totalUsers'));
    }



    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user-management.create');
    }

    /**
     * Store a newly created user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'status' => [Rule::enum(UserStatus::class)],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'password' => bcrypt($request->password)
        ]);

        if ($request->hasFile('profile_picture')) {
            $user->clearMediaCollection();
            $user
                ->addMediaFromRequest('profile_picture')
                ->toMediaCollection();
        }

        return redirect()->route('admin.user-management.edit', $user)->with('success', 'User created successfully.');
    }


    /**
     * Show the form for editing an existing user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $user->load('addresses');
        $countries = Country::orderBy('name')->get();
        return view('admin.user-management.edit', compact('user', 'countries'), ['addressTypes' => AddressType::cases()]);
    }

    /**
     * Update an existing user.
     *
     * This method validates the incoming request data, updates the user's information in the database,
     * including an optional profile picture update, and redirects back to the user management page
     * with a success message.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing the updated user data.
     * @param  \App\Models\User  $user The User model instance to be updated, injected via route model binding.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the user management page with a success message.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username,'.$user->id, // unique except current
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed', //Password can be nullable
            'status' => [Rule::enum(UserStatus::class)]
        ]);

        if ($request->hasFile('profile_picture')) {
            $user->clearMediaCollection();
            $user
                ->addMediaFromRequest('profile_picture')
                ->toMediaCollection();
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) { //Update only if password field is not empty
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.user-management')->with('success', 'User updated successfully.');
    }
    
    /**
     * Removes the profile picture for the given user.
     *
     * @param  \App\Models\User  $user The user whose profile picture should be removed.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function removeProfilePicture(User $user)
    {
        $user->clearMediaCollection();
        return redirect()->back();
    }
    
     /**
     * Delete a user.
     *
     * @param \App\Models\User $user The user to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user-management')->with('success', 'User deleted successfully.');
    }

    /**
     * Performs a bulk action on selected users.
     *
     * @param \Illuminate\Http\Request $request The request containing the action and selected user IDs.
     * @return \Illuminate\Http\RedirectResponse Redirects to the user management page with a success or error message.
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedUsers = $request->input('selected_users');
        if ($selectedUsers && count($selectedUsers) > 0) {
            switch ($action) {
                case 'delete':
                    User::whereIn('id', $selectedUsers)->delete();
                    break;
                case 'activate':
                    User::whereIn('id', $selectedUsers)->update(['status' => 'active']);
                    break;
                case 'deactivate':
                    User::whereIn('id', $selectedUsers)->update(['status' => 'inactive']);
                    break;
                case 'ban':
                    User::whereIn('id', $selectedUsers)->update(['status' => 'banned']);
                    break;
            }

            return redirect()->route('admin.user-management')->with('success', 'Bulk action performed successfully.');
        }

        return redirect()->route('admin.user-management')->with('error', 'No users selected.');
    }
}
