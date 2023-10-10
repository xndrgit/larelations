@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Display success message if it exists in the session -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">{{ $post->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($post->image)
                                <img src="{{ $post->image }}" alt="Post Image" class="img-fluid">
                            @else
                                No Image
                            @endif
                        </div>
                        <div class="badge-pill text-center"
                             style="background-color: {{$post->category->color}}">{{ $post->category->name }}</div>
                        <p>{{ $post->content }}</p>
                        <p><strong>Published:</strong> {{ $post->published ? 'Yes' : 'No' }}</p>
                        <p><strong>Published At:</strong> {{ $post->published_at }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
