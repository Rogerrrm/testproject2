import { test, run } from 'vitest';
import { Schema, Blueprint } from 'laravel-migration';

test('Migración de tabla restaurants', ({ assert }) => {
    // Simular la migración
    const migration = new Migration();
    migration.up();

    // Verificar si la tabla fue creada
    assert.isTrue(Schema.hasTable('restaurants'), 'La tabla restaurants fue creada');

    // Verificar si las columnas fueron creadas
    const columns = ['id', 'name', 'description', 'latitude', 'longitude', 'average_rating', 'user_id', 'created_at', 'updated_at'];

    columns.forEach(column => {
        assert.isTrue(Blueprint.hasColumn('restaurants', column), `La columna ${column} fue creada`);
    });
});

run();
