@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
    <div class="container">
        <h1 class="section-title">Edit User</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1rem;">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-box" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-box" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label><input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}> Is
                    Admin</label>
            </div>

            <button class="btn btn-primary" type="submit">Save</button>
            <a href="{{ route('admin.manage') }}" class="btn btn-grey">Cancel</a>
        </form>
    </div>
@endsection