<template>
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ usuario.name }}
            </h5>
        </a>
        <a href="#"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            @click="showModal(usuario.id)">
            Editar
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>

        <a href="#"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            @click="eliminarUsuario(usuario.id)">
            Eliminar
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>


        <!-- Modal -->
        <div v-if="showModalFlag">
            <div class="modal-content">
                <span class="close" @click="showModalFlag = false">&times;</span>
                <h2>Editar {{ usuario.name }}</h2>
                <div class="input-group">
                    <label for="user-name">Name:</label>
                    <input type="text" id="user-name" v-model="usuario.name">
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

const props = defineProps({
    usuario: {
        type: Object,
        required: true,
    },
});

const selectedid = ref(null); // Inicializamos selectedid con null
const showModalFlag = ref(false);

function showModal(id) {
    selectedid.value = id;
    showModalFlag.value = true;
    console.log(selectedid.value);
    console.log('showModalFlag:', showModalFlag.value)
}

async function guardarCambios(id) {
    try {
        const response = await axios.post(`/usuarios/${id}`, { name: props.usuario.name });
        console.log(response.data);
        showModalFlag.value = false;
    } catch (error) {
        console.error(error);
    }
}


function eliminarUsuario(id) {
    axios.delete(`/usuarios/${id}`)
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.error(error);
        });
} 
</script>

<style>
.modal2 {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.6);
}


.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.input-group input {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.button-group {
    text-align: right;
}

.button-group button {
    padding: 10px 20px;
    margin-left: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button-group button:last-child {
    margin-left: 0;
}
</style>