@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>

        <!-- Display success message if it exists in the session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary" title="Create Post">
                <i class="fas fa-plus-circle"></i> Create Post
            </a>
        </div>

        <table class="table table-dark table-hover table-responsive">
            <thead class="thead-dark">
            <tr>
                <th>Author</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Published</th>
                <!-- <th>Published At</th> -->
                <th>Actions</th> <!-- Add Actions column -->
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->user->name }} {{$post->user->userDetail->last_name}}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="Post Image" style="max-width: 100px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $post->published ? 'Yes' : 'No' }}</td>
                    <!-- <td>{{ $post->published_at }}</td> -->
                    <td class="d-flex">
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-link" title="Show Post">
                            <i class="fas fa-eye"></i> Show
                        </a>
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-link" title="Edit Post">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link" title="Delete Post"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
