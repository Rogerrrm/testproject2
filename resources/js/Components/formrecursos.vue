<template>
    <form @submit.prevent="guardarRecurso">
        <div class="mb-4">
            <label for="titulo" class="block mb-2 font-semibold text-gray-700">Título:</label>
            <input type="text" id="titulo" v-model="titulo"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="contenido" class="block mb-2 font-semibold text-gray-700">Contenido:</label>
            <textarea id="editor" name="contenido" v-model="contenido"
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import axios from 'axios';

const Usuarios = ref([]);

onMounted(async () => {
    try {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                const usuariosHTML = Usuarios.value.map(user => `<li>${user.name}</li>`).join('');
                editor.setData(`<ul>${usuariosHTML}</ul>`);
            })
            .catch(error => {
                console.error(error);
            });
    } catch (error) {
        console.error('Error al obtener las Usuarios:', error);
    }
});


const titulo = ref('');
const contenido = ref('');
const visibilidad = ref('publico');

guardarRecurso: () => {
    axios.post('/recursos', {
        titulo: this.titulo,
        contenido: this.contenido,
        visibilidad: this.visibilidad
    })
        .then(response => {
            console.log('Recurso guardado con éxito:', response.data);
        })
        .catch(error => {
            console.error('Error al guardar el recurso:', error);
        });
}
</script>