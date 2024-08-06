@extends('layouts.app')

@section('content')
    <div class="container my-posts-container">
        <h1 class="mb-4 text-center text-white mt-5">My Posts</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card post-card">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                            <p class="card-text">
                                <strong>Status:</strong> 
                                <span class="{{ $post->approved ? ($post->active ? 'text-success' : 'text-warning') : 'text-danger' }}">
                                    {{ $post->approved ? ($post->active ? 'Active' : 'Inactive') : 'Not Approved' }}
                                </span>
                            </p>

                            <!-- Admin Actions -->
                            @if (Auth::user()->hasRole('superadmin'))
                                <div class="mb-2">
                                    @if ($post->approved)
                                        @if ($post->active)
                                            <form action="{{ route('posts.unapprove', $post->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-warning btn-sm">Unapprove</button>
                                            </form>
                                        @else
                                            <form action="{{ route('posts.activate', $post->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('posts.approve', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                    @endif
                                </div>
                            @endif

                            <!-- Edit and Delete Buttons -->
                            <div class="mt-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
<style>
    body {
        background: #f8f9fa; /* Light background for the page */
    }
    .my-posts-container {
        padding: 2rem;
    }
    .card {
        border-radius: .75rem;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }
    .post-card .card-body {
        padding: 1.5rem;
    }
    .card-title {
        font-size: 1.5rem;
        color: #333;
    }
    .card-text {
        font-size: 1rem;
        color: #555;
    }
    .btn-sm {
        padding: .375rem .75rem;
        font-size: .875rem;
        border-radius: .375rem;
    }
    .alert {
        border-radius: .375rem;
    }
    .alert-dismissible .close {
        padding: .5rem;
        margin: -.5rem -.5rem -.5rem auto;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>
@endpush
