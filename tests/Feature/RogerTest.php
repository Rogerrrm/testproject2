<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Curso;

class RutasTest extends TestCase
{
    use RefreshDatabase;

    public function testObtenerListaCursos()
    {
        $response = $this->get('/cursos');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
    public function testActualizarCurso()
    {
        $curso = Curso::factory()->create();

        $response = $this->put("/cursos/{$curso->id}", [
            'nombre' => 'Nuevo nombre del curso',
            'descripcion' => 'Nueva descripción del curso',

        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('cursos', [
            'id' => $curso->id,
            'nombre' => 'Nuevo nombre del curso',
            'descripcion' => 'Nueva descripción del curso',

        ]);
    }
}