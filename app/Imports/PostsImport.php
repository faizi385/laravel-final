<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class PostsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Set default user ID if not provided
        $userId = $row['user_id'] ?? Auth::id(); // Use the currently logged-in user's ID

        // Handle the case where 'tags' might be empty or not present
        $tags = isset($row['tags']) ? json_decode($row['tags']) : [];

        // Handle 'approved' and 'active' values as boolean
        $approved = isset($row['approved']) ? filter_var($row['approved'], FILTER_VALIDATE_BOOLEAN) : true;
        $active = isset($row['active']) ? filter_var($row['active'], FILTER_VALIDATE_BOOLEAN) : true;

        // Return a new Post instance
        return new Post([
            'user_id' => $userId,
            'title' => $row['title'] ?? 'No Title', // Provide a default value if 'title' is not present
            'content' => $row['content'] ?? '',
            'image' => $row['image'] ?? null,
            'tags' => json_encode($tags), // Ensure tags are encoded as JSON
            'approved' => $approved,
            'active' => $active,
            'created_at' => $row['created_at'] ?? now(),
            'updated_at' => $row['updated_at'] ?? now(),
        ]);
    }
}
