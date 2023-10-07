@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Create Post</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.posts.store') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                       name="title" value="{{ old('title') }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">Content:</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content"
                                          name="content">{{ old('content') }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <textarea class="form-control @error('image') is-invalid @enderror" id="image"
                                          name="image">{{ old('image') }}</textarea>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Add other form fields for image, published, published_at, etc. -->
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
