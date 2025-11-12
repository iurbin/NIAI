{{-- Assumes you have a layout file: resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            {{-- 1. Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Users List</h2>
                {{-- Assumes you have a named route for creating users --}}
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    Add New User
                </a>
            </div>

            {{-- 2. Users Table --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Joined</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Use @forelse to loop and handle empty state --}}
                                @forelse ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            {{-- Action Buttons --}}
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                            
                                            {{-- Delete Button (needs a form) --}}
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- This runs if $users is empty --}}
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 3. Pagination Links --}}
            <div class="d-flex justify-content-center mt-4">
                {{-- This renders the pagination links and respects the Bootstrap setting from AppServiceProvider --}}
                {!! $users->links() !!}
            </div>

        </div>
    </div>
</div>
@endsection