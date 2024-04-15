<template>
    <div class="max-w-xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ recursos.titulo }}
                {{ recursos.contenido_html }}
                {{ recursos.visibilidad }}
            </h5>
        </a>
        <div class="flex space-x-2">
            <button @click="showModal()"
                class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Editar
                <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M8.707 14.707a1 1 0 0 0 1.414 0L15 9.414V13a1 1 0 0 0 2 0V6a1 1 0 0 0-1-1h-7a1 1 0 0 0 0 2h3.586L8.707 9.293a1 1 0 0 0 0 1.414zM4 4a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2H4zm1 4a1 1 0 1 0 0 2h7a1 1 0 1 0 0-2H5z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <button @click="eliminarCurso(recursos.id)"
                class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Eliminar
                <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.293 4.293a1 1 0 0 1 1.414 0L10 8.586l3.293-3.293a1 1 0 1 1 1.414 1.414L11.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 0 1-1.414-1.414L8.586 10 5.293 6.707a1 1 0 0 1 0-1.414zM10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <!-- Modal -->
        <div v-if="showModalFlag" class="fixed inset-0 z-10 overflow-y-auto bg-gray-500 bg-opacity-75">
            <div class="flex items-center justify-center min-h-screen">
                <div class="relative w-1/2 max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg">
                    <button @click="showModalFlag = false"
                        class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none"
                        aria-label="Cerrar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold mb-4">Editar {{ recursos.titulo }}</h2>
                    <div class="mb-4">
                        <label for="curso-name" class="block mb-2 font-semibold text-gray-700">Titulo:</label>
                        <input type="text" id="curso-name" v-model="recursos.titulo"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="curso-name" class="block mb-2 font-semibold text-gray-700">Curso: {{
                            recursos.curso_id }}</label>
                    </div>
                    <div class="mb-4">
                        <label for="editor" class="block mb-2 font-semibold text-gray-700">Contenido:</label>
                        <textarea id="editor" v-model="recursos.contenido_html"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                            rows="6"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="curso-name" class="block mb-2 font-semibold text-gray-700">Visibilidad: {{
                            recursos.visibilidad }}</label>
                    </div>
                    <div class="flex justify-end">
                        <button
                            @click="guardarCambios(recursos.id, recursos.curso_id, recursos.titulo, recursos.contenido_html, recursos.visibilidad)"
                            class="px-4 py-2 mr-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                            Guardar</button>

                        <button @click="showModalFlag = false"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Define el prop curso
const props = defineProps({
    recursos: {
        type: Object,
        required: true,
    },
});

// Define la variable showModalFlag
const showModalFlag = ref(false);

// Define la función showModal
function showModal() {
    showModalFlag.value = true;
}

// Define la función eliminarCurso
function eliminarCurso(id) {
    console.log('Eliminar curso con ID:', id);
    axios.delete(`/cursos/${id}`)
        .then(response => {
            console.log(response.data.message);
        })
        .catch(error => {
            console.error('Error al eliminar el curso:', error);
        });
}

function guardarCambios(id, curso_id, titulo, contenido_html, visibilidad) {
    console.log('Guardar cambios para el recurso con ID:', id);

    axios.put(`/recursos/${id}`, {
        titulo: titulo,
        contenido_html: contenido_html,
        visibilidad: visibilidad,
        curso_id: curso_id
    })
        .then(response => {
            console.log(response.data.message);
        })
        .catch(error => {
            console.log(id, titulo, contenido_html, visibilidad, curso_id);
            console.error('Error al guardar los cambios:', error);
        });
}




onMounted(async () => {
    try {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change', () => {
                    recursos.contenido_html = editor.getData();
                });
            })
            .catch(error => {
            });
    } catch (error) {
        console.error('Error al obtener las Usuarios:', error);
    }
});
</script>
