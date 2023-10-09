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

        <table class="table table-dark table-hover table-responsive">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
{{--                <th>Actions</th> <!-- Add Actions column if needed -->--}}
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
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
                    {{--                    <td class="d-flex">--}}
                    {{--                        <a href="" class="btn btn-link" title="Show Post">--}}
                    {{--                            <i class="fas fa-eye"></i> Show--}}
                    {{--                        </a>--}}
                    {{--                        <a href="" class="btn btn-link" title="Edit Post">--}}
                    {{--                            <i class="fas fa-edit"></i> Edit--}}
                    {{--                        </a>--}}
                    {{--                        <form action="" method="POST"--}}
                    {{--                              style="display: inline;">--}}
                    {{--                            @csrf--}}
                    {{--                            @method('DELETE')--}}
                    {{--                            <button type="submit" class="btn btn-link" title="Delete Post"--}}
                    {{--                                    onclick="return confirm('Are you sure you want to delete this post?')">--}}
                    {{--                                <i class="fas fa-trash-alt"></i> Delete--}}
                    {{--                            </button>--}}
                    {{--                        </form>--}}
                    {{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
