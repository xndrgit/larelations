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
                <h2>Create Category</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
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
                        <label for="description">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                  name="description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="color"
                               name="color" value="{{ old('color') }}">
                        @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
