<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AllPostsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return a collection of all posts.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch all posts from the database
        return Post::all();
    }

    /**
     * Define the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Title',
            'Content',
            'Image',
            'Tags',
            'Approved',
            'Active',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map the data to be exported.
     *
     * @param  mixed  $post
     * @return array
     */
    public function map($post): array
    {
        return [
            $post->id,
            $post->user_id,
            $post->title,
            $post->content,
            $post->image ? asset('storage/' . $post->image) : null, // Export image URL if available
            $post->tags,
            $post->approved,
            $post->active,
            $post->created_at,
            $post->updated_at,
        ];
    }
}
