<template>
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ usuario.name }}
            </h5>
        </a>
        <a href="#"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            @click="showModal()">
            Editar
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>
        <a href="#"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Eliminar
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>

        <!-- Modal -->
        <div v-if="showModalFlag" class="modal">
            <div class="modal-content">
                <span class="close" @click="showModalFlag = false">&times;</span>
                <h2>Editar </h2>
                <div class="input-group">
                    <label for="empresa-name">Name:</label>
                    <input type="text" id="empresa-name" v-model="usuario.name">
                </div>
                <!-- Aquí puedes añadir más campos para editar -->
                <div class="button-group">
                    <button @click="guardarCambios(usuario.id)">Guardar</button>
                    <button @click="showModalFlag = false">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Define el prop usuario
const props = defineProps({
    usuario: {
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

// Define la función guardarCambios
// function guardarCambios(id) {
//     console.log(id);
//     // Aquí podrías realizar una llamada a una API para guardar los cambios del usuario
//     // Por ejemplo:
//     // axios.post(`/usuario/${id}`, {
//     //   name: usuario.name,
//     // })
//     // .then(response => {
//     //   console.log(response.data.message);
//     // })
//     // .catch(error => {
//     //   console.error('Error al guardar los cambios:', error);
//     //   console.log(id);
//     // });
// }
</script>