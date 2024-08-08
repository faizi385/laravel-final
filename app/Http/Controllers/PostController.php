<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PostsImport;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin')->only(['approve', 'unapprove']);
    }

    // Display all posts for users with pagination
 public function index()
{
    if (Auth::user()->hasRole('superadmin')) {
        // Superadmins see all posts with pagination
        $posts = Post::with('comments.user') // Eager load comments and user details
                     ->paginate(5);
    } else {
        // Regular users see only their own approved and active posts with pagination
        $posts = Post::where('user_id', Auth::id())
                     ->where('approved', true)
                     ->where('active', true)
                     ->with('comments.user') // Eager load comments and user details
                     ->paginate(5);
    }

    return view('posts.index', compact('posts'));
}

    // Display all active and approved posts without pagination on the welcome page
    public function welcome()
    {
        $posts = Post::where('active', true)
                     ->where('approved', true)
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('posts.welcome', compact('posts'));
    }

    // Show form for creating a new post
    public function create()
    {
        return view('posts.create');
    }

    // Store a newly created post in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string', // Ensure each tag is a string
        ]);
    
        $post = new Post();
        $post->user_id = Auth::id(); // Set the user_id to the currently authenticated user
        $post->title = $request->input('title');
        $post->content = $request->input('content');
    
        // Handle file upload if present
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'public');
        }
    
        // Encode tags as a JSON array
        $post->tags = json_encode($request->input('tags', []));
    
        // Set default visibility and approval
        $post->approved = true; // Set to true to make it visible immediately
        $post->active = true;   // Set to true to make it visible immediately
    
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
    

    // Show the specified post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // Update the specified post in storage
  
public function update(Request $request, Post $post)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'string', // Ensure each tag is a string
    ]);

    $post->title = $request->input('title');
    $post->content = $request->input('content');
    if ($request->hasFile('image')) {
        $post->image = $request->file('image')->store('images', 'public');
    }
    $post->tags = json_encode($request->input('tags', []));
    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
}
    // Remove the specified post from storage
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    // Display posts created by the authenticated user
    public function myPosts()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->paginate(5); // Fetch posts created by the user with pagination
        return view('posts.my-posts', compact('posts'));
    }

    // Like a post
    public function like(Post $post)
    {
        if (!$post->likes()->where('user_id', Auth::id())->exists()) {
            $post->likes()->create(['user_id' => Auth::id()]);
        }
    
        return response()->json([
            'success' => true,
            'likes_count' => $post->likes()->count(),
        ]);
    }
    
    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();
    
        return response()->json([
            'success' => true,
            'likes_count' => $post->likes()->count(),
        ]);
    }
    
  

    

    // Store a comment for a post
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
    
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->comment = $request->input('comment');
        $comment->save();
    
        return response()->json([
            'success' => true,
            'user_name' => Auth::user()->name, // Include user name
            'comment' => $comment->comment,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }
    

    // Display all posts in the feed (superadmins see all posts)
    public function feed()
    {
        $posts = Post::paginate(5); // Adjust the number of posts per page as needed
        return view('posts.index', compact('posts'));
    }

    // Activate a post (only for superadmins)
    public function activate(Post $post)
    {
        $post->active = true;
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post activated successfully.');
    }
 public function import(Request $request)
{
    $request->validate([
        'import_file' => 'required|mimes:xlsx,xls',
    ]);

    // Perform the import
    Excel::import(new PostsImport, $request->file('import_file'));

    // Redirect to the posts index with a success message
    return redirect()->route('posts.index')
                     ->with('success', 'Posts imported successfully.');
}


    // Approve a post (only for superadmins)
    public function approve(Post $post)
    {
        $post->approved = true;
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post approved successfully.');
    }

    // Unapprove a post (only for superadmins)
    public function unapprove(Post $post)
    {
        $post->approved = false;
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post unapproved successfully.');
    }
}
