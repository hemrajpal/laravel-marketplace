<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = config('locations.India', []);

        $now = now();

        // 1. Insert states
        $states = [];

        foreach ($locations as $stateName => $cities) {
            $states[] = [
                'name' => $stateName,
                'slug' => Str::slug($stateName),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('states')->upsert(
            $states,
            ['name'],
            ['slug', 'updated_at']
        );

        // 2. Get state IDs in ONE query
        $stateMap = DB::table('states')
            ->pluck('id', 'name');

        // 3. Build cities
        $cityRows = [];

        foreach ($locations as $stateName => $cities) {

            $stateId = $stateMap[$stateName];

            foreach ($cities as $cityName) {
                $cityRows[] = [
                    'state_id' => $stateId,
                    'name' => $cityName,
                    'slug' => Str::slug($cityName),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 4. Insert cities in batches
        foreach (array_chunk($cityRows, 1000) as $chunk) {
            DB::table('cities')->upsert(
                $chunk,
                ['state_id', 'name'],
                ['slug', 'updated_at']
            );
        }
    }
}