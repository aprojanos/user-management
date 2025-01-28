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
    public function index(Request $request)
    {
        $users = User::paginate(10);
        $totalUsers = User::count();

        return view('admin.user-management.index', compact('users', 'totalUsers'));
    }



    public function create()
    {
        return view('admin.user-management.create');
    }

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


    public function edit(User $user)
    {
        $user->load('addresses');
        $countries = Country::orderBy('name')->get();
        return view('admin.user-management.edit', compact('user', 'countries'), ['addressTypes' => AddressType::cases()]);
    }

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
    
    public function removeProfilePicture(User $user)
    {
        $user->clearMediaCollection();
        return redirect()->back();
    }
    
    
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user-management')->with('success', 'User deleted successfully.');
    }

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
