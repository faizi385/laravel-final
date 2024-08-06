@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center text-white">All Posts</h1>

        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card hover-effect">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                            <p class="card-text">
                                <small class="text-muted">Tags: {{ implode(', ', json_decode($post->tags)) }}</small>
                            </p>
                            <p class="card-text">
                                <strong>Status:</strong> 
                                <span class="{{ $post->approved ? ($post->active ? 'text-success' : 'text-warning') : 'text-danger' }}">
                                    {{ $post->approved ? ($post->active ? 'Active' : 'Inactive') : 'Not Approved' }}
                                </span>
                            </p>

                            <!-- Likes Section -->
                            <p class="mb-2">
                                <strong>Likes:</strong> 
                                <span id="like-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                                @if (Auth::check())
                                    @if ($post->likes()->where('user_id', Auth::id())->exists())
                                        <form action="{{ route('posts.unlike', $post->id) }}" method="POST" class="like-form" data-action="unlike" data-post-id="{{ $post->id }}" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="fas fa-thumbs-up text-primary"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form" data-action="like" data-post-id="{{ $post->id }}" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="far fa-thumbs-up text-secondary"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </p>
                            
                            </p>
                            

                            <!-- Comments Section -->
                            <h5>Comments</h5>
                            <div id="comments-container-{{ $post->id }}">
                                @forelse ($post->comments as $comment)
                                    <div class="card mb-2 border-light">
                                        <div class="card-body">
                                            <p><strong>{{ $comment->user->name }}</strong> said:</p>
                                            <p>{{ $comment->comment }}</p>
                                            <p class="text-muted">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No comments yet.</p>
                                @endforelse
                            </div>
                            
                            @if (Auth::check())
                                <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" class="comment-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control" rows="3" placeholder="Add a comment..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                                </form>
                            @endif
                            
                            

                            <!-- Actions -->
                            @if (Auth::user()->hasRole('superadmin'))
                                <!-- Superadmin Actions -->
                                <div class="mt-3">
                                    @if ($post->approved)
                                        @if ($post->active)
                                            <form action="{{ route('posts.unapprove', $post->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-warning">Unapprove</button>
                                            </form>
                                        @else
                                            <form action="{{ route('posts.activate', $post->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-success">Activate</button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('posts.approve', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>
                                    @endif

                                    @if (!$post->approved) <!-- Only show delete button for unapproved posts -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            @elseif (Auth::id() === $post->user_id)
                                <!-- User Actions -->
                                <div class="mt-3">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission for liking/unliking posts
    $(document).on('submit', '.like-form', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this);
        var action = form.data('action');
        var postId = form.data('post-id');
        var likeCountElement = $('#like-count-' + postId);
        var button = form.find('button');

        $.ajax({
            url: form.attr('action'), // URL from form action
            type: 'POST',
            data: form.serialize(), // Serialize form data
            success: function(response) {
                // Update the like count
                likeCountElement.text(response.likes_count);

                // Replace the form with the new form based on the action
                if (action === 'like') {
                    form.replaceWith(`
                        <form action="/posts/${postId}/unlike" method="POST" class="like-form" data-action="unlike" data-post-id="${postId}" style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-link p-0">
                                <i class="fas fa-thumbs-up text-primary"></i>
                            </button>
                        </form>
                    `);
                } else {
                    form.replaceWith(`
                        <form action="/posts/${postId}/like" method="POST" class="like-form" data-action="like" data-post-id="${postId}" style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-link p-0">
                                <i class="far fa-thumbs-up text-secondary"></i>
                            </button>
                        </form>
                    `);
                }
            },
            error: function(xhr) {
                console.error('An error occurred:', xhr.responseText); // Log any errors
            }
        });
    });

    // Handle form submission for commenting on posts
    $(document).on('submit', '.comment-form', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this);
        var postId = form.data('post-id');
        var commentInput = form.find('textarea');
        var commentsContainer = $('#comments-container-' + postId);

        $.ajax({
            url: form.attr('action'), // URL from form action
            type: 'POST',
            data: form.serialize(), // Serialize form data
            success: function(response) {
                // Append the new comment to the comments container
                commentsContainer.append(`
                    <div class="card mb-2 border-light">
                        <div class="card-body">
                            <p><strong>${response.user_name}</strong> said:</p>
                            <p>${response.comment}</p>
                            <p class="text-muted">${response.created_at}</p>
                        </div>
                    </div>
                `);

                // Clear the comment input field
                commentInput.val('');
            },
            error: function(xhr) {
                console.error('An error occurred:', xhr.responseText); // Log any errors
            }
        });
    });
});
</script>







@push('styles')
<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient background for the page */
        color: #333;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }
    .container {
         /* Slightly transparent background for better readability */
        padding: 20px;
        border-radius: 8px;
    }
    .card {
        border: 1px solid #e3e6e8;
        border-radius: .375rem;
        overflow: hidden;
        background: #ffffff; /* White background for cards */
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }
    .card-body {
        padding: 1.25rem;
    }
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .hover-effect:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        background: #f8f9fa; /* Slightly different background color on hover */
        border-color: #007bff; /* Blue border color on hover */
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .card-text {
        font-size: 1rem;
        color: #666;
    }
    .btn-link {
        color: inherit;
        font-size: 1.25rem;
    }
    .border-primary {
        border-color: #007bff !important;
    }
    .border-light {
        border-color: #f8f9fa !important;
    }
    .text-primary {
        color: #007bff !important;
    }
    .text-secondary {
        color: #6c757d !important;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
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
</style>
@endpush
