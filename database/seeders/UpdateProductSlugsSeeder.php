<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class UpdateProductSlugsSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing products that don't have slugs
        Product::whereNull('slug')->each(function ($product) {
            $slug = Str::slug($product->name);

            // Ensure uniqueness
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $product->update(['slug' => $slug]);
        });
    }
}
