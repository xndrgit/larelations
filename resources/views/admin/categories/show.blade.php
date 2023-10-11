@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Category Details</h1>

        <!-- Display success message if it exists in the session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>{{ $category->name }}</h2>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $category->name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Description:</dt>
                    <dd class="col-sm-9">{{ $category->description ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Color:</dt>
                    <dd class="col-sm-9">
                        @if($category->color)
                            @if(preg_match('/^#[A-Fa-f0-9]{6}$/', $category->color))
                                <div style="background-color: {{ $category->color }}; width: 30px; height: 30px;"></div>
                            @else
                                <span
                                    class="font-weight-bolder text-danger">Invalid Color Format: {{ $category->color }}</span>
                            @endif
                        @else
                            N/A
                        @endif
                    </dd>
                </dl>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-link"
                   title="Edit Category">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
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

        <!-- ... (previous code) ... -->

        <div class="container mt-4">
            <h2>Posts in this Category</h2>

            @if ($category->post->count() > 0)

                <div class="d-flex justify-content-between flex-wrap col-12">
                    @foreach ($category->post as $post)
                        <div class="card col-3 m-4">
                            <div class="card-header">
                                <a href="{{ route('admin.posts.show', $post->id) }}">{{$post->title}}</a>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <img class="img-fluid" width="100" height="100" alt="post_image_{{$post->id}}"
                                     src="{{$post->image}}">
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <p>No posts in this category yet.</p>
            @endif
        </div>

        <!-- ... (remaining code) ... -->


    </div>
@endsection
