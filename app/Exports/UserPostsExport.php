<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserPostsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Adjust the query to export posts specific to the logged-in user
        return Post::where('user_id', auth()->id())->get();
    }

    public function headings(): array
    {
        return [
            
            'User Name',
            'Title',
            'Content',
            'Image',
            'Tags',
            
        ];
    }

    public function map($post): array
    {
        return [
          
            $post->user->name, // Replace user_id with user name
            $post->title,
            $post->content,
            $post->image ? asset('storage/' . $post->image) : null, // Export image URL
            $post->tags,
           
        ];
    }
}
