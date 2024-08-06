<!-- resources/views/posts/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <!-- Add your CSS here -->
</head>
<body>
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ $post->title }}" required>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required>{{ $post->content }}</textarea>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image">
        @endif

        <label for="tags">Tags:</label>
        <input type="text" id="tags" name="tags[]" value="{{ implode(', ', json_decode($post->tags, true)) }}">

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('posts.index') }}">Back to Posts</a>
</body>
</html>
