<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('json_data/products.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data as $item) {

            // MAIN IMAGE
            if (!file_exists(public_path('upload/product/'))) {
                mkdir(public_path('upload/product/'), 0777, true);
            }

            // use your helper to generate a filename
            $productImage = "";

            $imageContent = @file_get_contents($item['image']);
            if ($imageContent !== false) {
                $productImage = fileName('png');
                file_put_contents(public_path("upload/product/{$productImage}"), $imageContent);
            }

            // GALLERY IMAGES (ARRAY OF URL STRINGS)
            if (!file_exists(public_path('upload/product-gallery/'))) {
                mkdir(public_path('upload/product-gallery/'), 0777, true);
            }

            $galleryImages = [];
            foreach ($item['gallery_images'] as $gImageUrl) {
                // generate a new random name for each gallery image
                $gFilename = fileName('png');
                $gContent = @file_get_contents($gImageUrl);
                if ($gContent !== false) {
                    file_put_contents(public_path("upload/product-gallery/{$gFilename}"), $gContent);
                    $galleryImages[] = $gFilename;
                }
            }

            Product::create([
                'category_id' => $item['category_id'],

                'name' => $item['name'],
                'description' => $item['description'],
                'short_description' => $item['short_description'],

                'price' => $item['price'],
                'discount_price' => $item['discount_price'],
                'quantity' => $item['quantity'],

                'is_active' => $item['is_active'],
                'is_featured' => $item['is_featured'],

                'image' => $productImage,
                'gallery_images' => json_encode($galleryImages),

                'dimensions' => $item['dimensions'],

                'meta_title' => $item['meta_title'],
                'meta_description' => $item['meta_description'],
                'meta_keywords' => $item['meta_keywords'],

                'rating' => $item['rating'],
                'reviews_count' => $item['reviews_count'],
            ]);
        }
    }
}
