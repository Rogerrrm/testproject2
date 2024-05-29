<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateRestaurantsTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function restaurants_table_is_created_with_correct_columns()
    {
        // Run the migration
        $this->artisan('migrate');

        // Check if the table exists
        $this->assertTrue(Schema::hasTable('restaurants'));

        // Check if the columns exist
        $columns = ['id', 'name', 'description', 'latitude', 'longitude', 'average_rating', 'user_id', 'created_at', 'updated_at'];

        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('restaurants', $column));
        }
    }
}
