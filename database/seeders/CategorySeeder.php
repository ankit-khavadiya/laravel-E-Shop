<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('json_data/categories.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data as $item) {
            Category::create([
                'parent_id' => $item['parent_id'] ?? 0,
                'name' => $item['name'],
                'description' => $item['description'],
                'is_active' => $item['is_active'] ?? 1,
            ]);
        }
    }
}
