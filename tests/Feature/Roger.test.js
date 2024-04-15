import { test, run } from 'vitest';
import axios from 'axios';

test('Validar llamada asíncrona con Axios', async ({ assert }) => {

    const responseData = [
        { id: 1, nombre: 'Curso 1' },
        { id: 2, nombre: 'Curso 2' },
        { id: 3, nombre: 'Curso 3' }
    ];
    axios.get.mockResolvedValue({ data: responseData });


    const response = await axios.get('/cursos');


    assert.equal(response.status, 200, 'La llamada asíncrona se realizó correctamente');


    assert.equal(response.data.length, 3, 'Se recibieron 3 cursos');
    assert.equal(response.data[0].nombre, 'Curso 1', 'El nombre del primer curso es correcto');
    assert.equal(response.data[1].id, 2, 'El ID del segundo curso es correcto');

});

run();
