@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>

        <!-- Display success message if it exists in the session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
        </div>

        <table class="table table-dark table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Roles</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Actions</th> <!-- Add Actions column if needed -->
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>

                    <td>
                        @foreach($user->roles as $role)
                            <div class="badge-pill text-center my-2"
                                 style="background-color: {{ $role->name === 'Secret' ? 'red' : 'blue' }}">
                                {{ $role->name }}
                            </div>
                        @endforeach
                    </td>

                    <td>{{ $user->name }}</td>
                    <td>
                        @if($user->userDetail)
                            {{ $user->userDetail->last_name }}
                        @else
                            No Last Name
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->userDetail)
                            {{ $user->userDetail->phone_number }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="d-flex">
                        <a href="{{route('admin.users.show', $user->id)}}" class="btn btn-link" title="Show Post">
                            <i class="fas fa-eye"></i> Show
                        </a>
                        <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-link" title="Edit Post">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
