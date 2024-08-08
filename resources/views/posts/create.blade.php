@extends('layouts.app')

@push('styles')
<style>
    /* Custom styles for Create Post page */
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient background for the page */
        color: #333;
    }

    .container {
        max-width: 900px;
    }

    .card {
        border-radius: 8px;
        background-color: #ffffff; /* White background for cards */
        border: 1px solid #e3e6e8;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    }

    .btn-primary {
        background-color: #506983;
        border-color: #4d555e;
        color: #fff;
        border-radius: 5px;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .text-danger {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .row.justify-content-center {
        margin-top: 3rem;
    }

    .card.shadow-sm {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6e8;
        padding: 1rem;
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
        border-radius: 5px;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
</style>
@endpush

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center text-white ">Create a New Post</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <!-- Post Creation Form -->
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    <!-- Example tags; replace these with your actual tags -->
                                    <option value="Travel">Travel</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Playing">Playing</option>
                                    <!-- Add more options as needed -->
                                </select>
                                @error('tags')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </form>

                        <!-- Import Form -->
                        <div class="mt-4">
                            <h3 class="text-center text-white">Import Posts from Excel</h3>
                            <form action="{{ route('posts.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="import_file" class="form-label">Select Excel File</label>
                                    <input type="file" name="import_file" id="import_file" class="form-control" required>
                                    @error('import_file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-secondary">Import Posts</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
