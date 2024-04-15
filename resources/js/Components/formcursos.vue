<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-semibold text-center mb-6">Formulario de Cursos</h1>

        <form @submit.prevent="submitForm">

            <div class="mb-4">
                <label for="nombre" class="block font-medium text-gray-700">Nombre:</label>
                <input type="text" id="nombre" v-model="formData.nombre" required
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="etapa" class="block font-medium text-gray-700">Etapa:</label>
                <select id="etapa" v-model="formData.etapa" required
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    <option value="ESO">ESO</option>
                    <option value="BTX">BTX</option>
                    <option value="CF">CF</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block font-medium text-gray-700">Descripción (máx. 150
                    palabras):</label>
                <textarea id="descripcion" v-model="formData.descripcion" rows="4" maxlength="750" required
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Guardar</button>
        </form>
    </div>
</template>

<script setup>
import axios from 'axios';

const formData = {
    nombre: '',
    etapa: '',
    descripcion: ''
};

const submitForm = async () => {
    try {
        const response = await axios.post('/guardarcurso', formData);
        console.log(response.data);
    } catch (error) {
        console.error(error);
    }
};
</script>
