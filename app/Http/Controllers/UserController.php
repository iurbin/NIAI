<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;   // <-- Import
use App\Http\Requests\UpdateUserRequest;   // <-- Import
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);
        // Returns a view, passing all users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Validation already passed!
        // Get validated data from the request
        $validatedData = $request->validated();

        $newuser = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // <-- ALWAYS hash passwords
        ]);

        $newuser->assignRole($request['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {   
        $roles = Role::pluck('name', 'id');
        $user->load('roles');
        foreach($user->roles as $role):                    
            $user->role_id =  $role->id;
        endforeach;
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        
        
        // Validation already passed!
        $validatedData = $request->validated();

        $user->update($validatedData);
        $user->syncRoles([]);
        $user->assignRole($request['role']);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
