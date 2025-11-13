@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            User basic information.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Name</label>
                            <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Email Address</label>
                            <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Roles & Permissions</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Your assigned roles.
                        </p>
                    </div>
                    
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Your Roles</label><br>
                        
                        {{-- Check if the user has any roles --}}
                        @if($user->roles->isNotEmpty())
                            
                                {{-- Loop through the roles collection --}}
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary text-uppercase">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            
                        @else
                            <p class="badge bg-warning text-uppercase">You have not been assigned any roles.</p>
                        @endif
                    </div>

                    {{-- BONUS: Display all permissions (including those via roles) --}}
                    <div class="mt-6">
                        <label class="block font-medium text-sm text-gray-700">Your Permissions</label>
                        @if($user->getAllPermissions()->isNotEmpty())
                             <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($user->getAllPermissions() as $permission)
                                    <span class="badge bg-primary text-uppercase">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                             <br><p class="badge bg-warning text-uppercase">You have no permissions.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection