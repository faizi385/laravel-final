@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <h3 class="card-title mb-4">Welcome {{ Auth::user()->name }}</h3>
                <p class="card-text mb-4">Manage your posts and view the latest feed from here.</p>
                <div class="d-flex justify-content-center">
                    @if (Auth::user()->hasRole('superadmin'))
                        <a href="{{ route('posts.index') }}" class="btn btn-primary mx-2">Feed</a>
                        <a href="{{ route('posts.index') }}" class="btn btn-success mx-2">Manage Posts</a>
                        <a href="{{ route('users.index') }}" class="btn btn-warning mx-2">Manage Users</a>
                    @else
                        <a href="{{ route('posts.myPosts') }}" class="btn btn-info mx-2">View My Posts</a>
                        <a href="{{ route('posts.index') }}" class="btn btn-primary mx-2">Feed</a>
                        <a href="{{ route('posts.create') }}" class="btn btn-success mx-2">Create Post</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(120deg, #e0f7fa, #80deea); /* Soft gradient background */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }
    .dashboard-card {
        background: #ffffff; /* White background for card */
        border: 1px solid #ddd;
        border-radius: .75rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        width: 100%;
        max-width: 600px; /* Increased max-width */
        padding: 2rem; /* Added padding */
    }
    .dashboard-card:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }
    .card-title {
        font-size: 2rem; /* Larger font size */
        font-weight: 600;
        color: #333;
    }
    .card-text {
        font-size: 1.1rem;
        color: #666;
    }
    .btn-primary, .btn-success, .btn-info, .btn-warning {
        font-size: 1rem;
        padding: 0.25rem 0.5rem;
        border-radius: .5rem; /* Rounded button corners */
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .btn-primary {
        background-color: #040c1b; /* Primary button color */
        border-color: #040c1b;
    }
    .btn-success {
        background-color: #1e3a8a; /* Darker shade for contrast */
        border-color: #1e3a8a;
    }
    .btn-info {
        background-color: #3b82f6; /* Light blue shade */
        border-color: #3b82f6;
    }
    .btn-warning {
        background-color: #fbbf24; /* Bright yellow for emphasis */
        border-color: #fbbf24;
    }
    .btn-primary:hover {
        background-color: #030a1b; /* Darker shade on hover */
        border-color: #030a1b;
    }
    .btn-success:hover {
        background-color: #1e40af; /* Darker blue shade on hover */
        border-color: #1e40af;
    }
    .btn-info:hover {
        background-color: #2563eb; /* Darker blue on hover */
        border-color: #2563eb;
    }
    .btn-warning:hover {
        background-color: #f59e0b; /* Darker yellow on hover */
        border-color: #f59e0b;
    }
</style>
@endpush
