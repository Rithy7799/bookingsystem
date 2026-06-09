<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users.view'])->only('List');
        $this->middleware(['permission:users.create'])->only('Store');
        $this->middleware(['permission:users.delete'])->only('Delete');
    }

   public function List(){
        $user= User::all();
        $user = User::orderBy('created_at', 'desc')
        ->paginate(5) // change 10 to number of items per page
        ->withQueryString(); // keep ?time= in pagination links
    return view('Backend.User.List',compact('user'));
   }

   public function Create(){
      return view('Backend.User.Create');
   }

 public function Store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:users,name',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:4',
        'role' => 'required|in:admin,staff',
        'status' => 'required|in:active,inactive',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->status = $request->status;

    // Handle profile image
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = rand(1000, 9999) . '_' . $file->getClientOriginalExtension();
        $file->move(public_path('User'), $filename);
        $user->image = $filename;
    }

    $user->save();

    // Assign role
    if ($request->role === 'admin') {
        $user->assignRole('admin');
    } elseif ($request->role === 'staff') {
        $user->assignRole('staff');
    }

    return redirect()->route('list.user')->with('success', 'User added successfully');
}

public function delete($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('list.user')->with('success', 'User deleted successfully.');
}
}