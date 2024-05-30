<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateRestaurantsTableTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

    /** @test */
    public function a_restaurant_can_be_created()
    {
        // Run the migration
        $this->artisan('migrate');

        // Crear un usuario simulado
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/crearrestaurante', [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'average_rating' => $this->faker->numberBetween(1, 5),
        ]);

        // Verificar si la solicitud fue exitosa
        $response->assertStatus(201);

        // Obtener los datos enviados en la solicitud
        $requestData = $response->json();

        // Verificar si el restaurante fue almacenado correctamente en la base de datos
        $this->assertDatabaseHas('restaurants', [
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'user_id' => $user->id,
        ]);

        // Obtener las coordenadas almacenadas en la base de datos
        $storedRestaurant = Restaurant::where('name', $requestData['name'])->first();
        $storedLatitude = $storedRestaurant->latitude;
        $storedLongitude = $storedRestaurant->longitude;

        // Calcular la distancia entre las coordenadas almacenadas y las coordenadas enviadas
        $distance = $this->calculateDistance($requestData['latitude'], $requestData['longitude'], $storedLatitude, $storedLongitude);

        // Verificar si la distancia es menor que un umbral dado (en metros, por ejemplo)
        $this->assertTrue($distance < 1); // Cambia este umbral según sea necesario
    }

    /**
     * Calcula la distancia entre dos puntos geográficos usando la fórmula del haversine.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radio de la Tierra en metros

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}