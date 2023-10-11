@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Categories</h1>

        <!-- Display success message if it exists in the session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
        </div>

        <table class="table table-dark table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Color</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name ?? 'N/A' }}</td>
                    <td>{{ $category->description ?? 'N/A' }}</td>
                    <td>
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
                    </td>
                    <td class="d-flex">
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-link"
                           title="Show Category">
                            <i class="fas fa-eye"></i> Show
                        </a>
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
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
