<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin'); // Only superadmins can access this
    }

    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('users.index', compact('users'));
    }
    public function destroy(User $user)
    {
        // Ensure superadmin cannot delete themselves
        if (Auth::id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
