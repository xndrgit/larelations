@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Create User</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name" value="{{ old('name') }}">

                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" value="{{ old('email') }}">

                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Password:</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                               name="password" value="{{ old('password') }}">

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- You can add fields for other user details here -->

                    <div class="form-group">
                        <label for="roles">Roles:</label><br>
                        @foreach($roles as $role)
                            <div class="form-check @error('roles') is-invalid @enderror">
                                <input type="checkbox" class="form-check-input" id="role_{{ $role->id }}" name="roles[]"
                                       value="{{ $role->id }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
