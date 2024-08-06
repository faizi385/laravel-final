@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-5 text-white text-center display-4 font-weight-bold font-italic">Welcome to the Feed</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (Auth::check())
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('posts.create') }}" class="btn btn-primary mx-2 btn-lg">Create Post</a>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary mx-2 btn-lg">Feed</a>
            </div>
        @else
            {{-- <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('login') }}" class="btn btn-primary mx-2 btn-lg">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary mx-2 btn-lg">Register</a>
            </div> --}}
        @endif

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-0 rounded-lg">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->content }}</p>
                            <p class="card-text">
                                <small class="text-muted">Tags: {{ implode(', ', json_decode($post->tags)) }}</small>
                            </p>
                            <p class="card-text">
                                <strong>Status:</strong> 
                                <span class="{{ $post->active ? 'text-success' : 'text-warning' }}">
                                    {{ $post->active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>

                            <!-- Likes Section -->
                            <p>
                                <strong>Likes:</strong> 
                                <span>{{ $post->likes()->count() }}</span>
                                @if (Auth::check())
                                    @if ($post->likes()->where('user_id', Auth::id())->exists())
                                        <form action="{{ route('posts.unlike', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="fas fa-thumbs-up text-primary"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('posts.like', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="far fa-thumbs-up text-secondary"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </p>

                            <!-- Comments Section -->
                            <h5 class="font-weight-bold">Comments</h5>
                            @foreach ($post->comments as $comment)
                                <div class="card mb-2 shadow-sm border-0">
                                    <div class="card-body">
                                        <p><strong>{{ $comment->user->name }}</strong> said:</p>
                                        <p>{{ $comment->content }}</p>
                                        <p class="text-muted">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if (Auth::check())
                                <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" rows="3" placeholder="Add a comment..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-white text-center">No Posts Available.</p>
            @endforelse
        </div>
    </div>
@endsection
