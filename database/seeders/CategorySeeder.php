<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            /*
            |--------------------------------------------------------------------------
            | Product Categories
            |--------------------------------------------------------------------------
            */

            'product' => [

                'Mobiles' => [
                    'Smartphones',
                    'Tablets',
                    'Mobile Accessories',
                    'Smart Watches',
                ],

                'Cars' => [
                    'Sedan',
                    'SUV',
                    'Hatchback',
                    'Luxury Cars',
                    'Car Accessories',
                ],

                'Bikes' => [
                    'Motorcycles',
                    'Scooters',
                    'Bicycles',
                    'Bike Accessories',
                ],

                'Property' => [
                    'Flats',
                    'Houses',
                    'Plots',
                    'Commercial Property',
                    'PG & Rooms',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Service Categories
            |--------------------------------------------------------------------------
            */

            'service' => [

                'Web Development' => [
                    'PHP Development',
                    'Laravel Development',
                    'WordPress Development',
                    'React Development',
                ],

                'Home Services' => [
                    'Electrician',
                    'Plumber',
                    'Carpenter',
                    'Painter',
                    'AC Repair',
                ],

                'Education' => [
                    'School Tuition',
                    'College Tuition',
                    'Computer Training',
                    'Language Classes',
                ],

                'Beauty & Salon' => [
                    'Hair Salon',
                    'Makeup Artist',
                    'Beauty Services',
                    'Spa Services',
                ],
            ],
        ];

        foreach ($categories as $type => $categoryList) {

            foreach ($categoryList as $categoryName => $children) {

                /*
                |--------------------------------------------------------------------------
                | Parent Category
                |--------------------------------------------------------------------------
                */

                $category = Category::updateOrCreate(
                    [
                        'slug' => Str::slug($categoryName),
                    ],
                    [
                        'parent_id' => null,
                        'name' => $categoryName,
                        'type' => $type,
                        'description' => $categoryName . ' ' . $type . ' category',
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | Child Categories
                |--------------------------------------------------------------------------
                */

                foreach ($children as $childName) {

                    Category::updateOrCreate(
                        [
                            'slug' => Str::slug($childName),
                        ],
                        [
                            'parent_id' => $category->id,
                            'name' => $childName,
                            'type' => $type,
                            'description' => $childName . ' under ' . $categoryName,
                        ]
                    );
                }
            }
        }
    }
}