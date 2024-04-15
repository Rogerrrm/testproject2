<template>
    <form @submit.prevent="guardarRecurso">
        <div class="mb-4">
            <label for="titulo" class="block mb-2 font-semibold text-gray-700">Título:</label>
            <input type="text" id="titulo" v-model="titulo"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="curso" class="block mb-2 font-semibold text-gray-700">Curso:</label>
            <select id="curso" v-model="selectedCurso" @change="updateCursoId"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                <option v-for="curso in cursos" :key="curso.id" :value="curso.id">{{ curso.nombre }}</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="editor" class="block mb-2 font-semibold text-gray-700">Contenido:</label>
            <textarea id="editor" v-model="contenido"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                rows="6"></textarea>
        </div>

        <div class="mb-4">
            <label for="visibilidad" class="block mb-2 font-semibold text-gray-700">Visibilidad:</label>
            <select id="visibilidad" v-model="visibilidad"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                <option value="publico">Público</option>
                <option value="privado">Privado</option>
            </select>
        </div>

        <button type="submit"
            class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Guardar</button>
    </form>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const titulo = ref('');
const contenido = ref('');
const visibilidad = ref('publico');
const selectedCurso = ref(null); // Almacena el ID del curso seleccionado

const props = defineProps({
    cursos: {
        type: Array,
        required: true,
    },
});

const guardarRecurso = () => {
    axios.post('/recursos', {
        titulo: titulo.value,
        contenido: contenido.value,
        visibilidad: visibilidad.value,
        curso_id: selectedCurso.value // Agregar el ID del curso al objeto enviado en la solicitud
    })
        .then(response => {
            console.log('Recurso guardado con éxito:', response.data);
        })
        .catch(error => {
            console.error('Error al guardar el recurso:', error);
        });
};

const updateCursoId = () => {
    // Método para actualizar el ID del curso seleccionado
    const selectedCursoIndex = document.querySelector('#curso').selectedIndex;
    selectedCurso.value = props.cursos[selectedCursoIndex].id;
};

onMounted(async () => {
    try {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change', () => {
                    contenido.value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    } catch (error) {
        console.error('Error al obtener las Usuarios:', error);
    }
});
</script>
