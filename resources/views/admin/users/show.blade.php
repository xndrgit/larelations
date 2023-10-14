@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Display success message if it exists in the session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Roles:</th>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge-pill text-center mr-2"
                                      style="background-color: {{ $role->name === 'Secret' ? 'red' : 'blue' }}">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Last Name:</th>
                        <td>
                            @if($user->userDetail)
                                {{ $user->userDetail->last_name }}
                            @else
                                No Last Name
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number:</th>
                        <td>
                            @if($user->userDetail)
                                {{ $user->userDetail->phone_number }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-link">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link"
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
