<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class UpdateNewsSlugsSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing news that don't have slugs
        News::whereNull('slug')->each(function ($news) {
            $slug = Str::slug($news->title);

            // Ensure uniqueness
            $originalSlug = $slug;
            $counter = 1;
            while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $news->update(['slug' => $slug]);
        });
    }
}
