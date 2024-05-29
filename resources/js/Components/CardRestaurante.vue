<script setup>
import Restaurante from '@/Pages/restaurante.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue'

const props = defineProps({
    Restaurant: Object,
});
console.log(props.Restaurant);
// Variable reactiva para controlar la visibilidad de la modal
const showModal = ref(false);

// Función para abrir la modal
const openModal = () => {
    showModal.value = true;
};

// Función para cerrar la modal
const closeModal = () => {
    showModal.value = false;
};

function deleteEvent(id) {
    console.log("Deleting event with ID:", id);
    axios.delete(`/deleterestaurante/${id}`)
        .then(response => {
            console.log('Evento eliminado:', response.data);
        })
        .catch(error => {
            console.error('Error al eliminar el evento:', error);
        });
}

// Objeto para almacenar los datos editados del restaurante
const editedRestaurant = ref({
    name: props.Restaurant.name,
    description: props.Restaurant.description,
    latitude: props.Restaurant.latitude,
    longitude: props.Restaurant.longitude,
});

// Función para enviar el formulario
const updaterestaurante = () => {
    // Datos del restaurante a actualizar
    const updatedRestaurantData = {
        name: editedRestaurant.value.name,
        description: editedRestaurant.value.description,
        latitude: editedRestaurant.value.latitude,
        longitude: editedRestaurant.value.longitude,
        // Otros campos del restaurante...
    };

    // ID del restaurante que se está editando (asumo que lo obtienes de alguna manera)
    const restaurantId = props.Restaurant.id; // Aquí deberías obtener el ID del restaurante

    // Realizar la solicitud de actualización al servidor
    axios.put(`/updaterestaurants/${restaurantId}`, updatedRestaurantData)
        .then(response => {
            // Manejar la respuesta del servidor
            console.log('Restaurante actualizado:', response.data);
            // Cerrar la modal después de actualizar exitosamente
            closeModal();
        })
        .catch(error => {
            // Manejar errores de la solicitud
            console.error('Error al actualizar el restaurante:', error);
        });

};
</script>

<template>
    <div class="flex flex-col items-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
        v-if="Restaurant">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ Restaurant.name }}
                <!-- {{ event }} -->
            </h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ Restaurant.description ?
                Restaurant.description.slice(0, 70) : '' }}</p>
        </div>

        <div class="flex space-x-2 p-4 ml-auto">
            <Link :href="route('inforestaurante', { id: Restaurant.id })" :Restaurant="Restaurant">
            <button type="button"
                class="focus:outline-none text-white  bg-purple-600 hover:bg-purple-500 focus:ring-4 focus:ring-purple-600 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-600 dark:focus:ring-purple-600">
                Informacion
            </button>
            </Link>
            <button type="button"
                class="focus:outline-none text-white bg-purple-600 hover:bg-purple-500 focus:ring-4 focus:ring-purple-600 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-600 dark:focus:ring-purple-600"
                @click="openModal">
                Editar
            </button>
            <button type="button"
                class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                @click="deleteEvent(Restaurant.id)">Eliminar</button>
        </div>

        <!-- Modal de edición del restaurante -->
        <div v-if="showModal" class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Contenido de la modal -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <!-- Formulario de edición del restaurante -->
                    <form @submit.prevent="updaterestaurante">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Editar Restaurante</h3>
                            <!-- Campos del formulario para editar el restaurante -->
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input v-model="editedRestaurant.name" type="text" id="nombre"
                                    class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="descripcion"
                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea v-model="editedRestaurant.description" id="descripcion"
                                    class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitud</label>
                                <input v-model="editedRestaurant.latitude" type="text" id="latitude"
                                    class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitud</label>
                                <input v-model="editedRestaurant.longitude" type="text" id="longitude"
                                    class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <!-- Otros campos del formulario... -->
                        </div>

                        <!-- Botón para cerrar la modal -->
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar Cambios
                            </button>
                            <button @click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pop {
    background-color: rgb(142, 36, 170);
}

.pop:hover {
    background-color: rgb(142, 36, 170);
}
</style>