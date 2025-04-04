<?php

namespace Database\Seeders;

use App\Models\CustomerCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Retailer', 'Wholesaler', 'Distributor', 'Supermarket', 'Other'];

        foreach ($categories as $category) {
            CustomerCategory::create(['name' => $category, 'description' => "This is a $category"]);
        }
    }
}
