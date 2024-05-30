<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, nextTick } from 'vue'
import { defineProps } from 'vue';
import { onMounted } from 'vue';
import L from 'leaflet';
import CardRestaurante from '@/Components/CardRestaurante.vue';
import CardComentarios from '@/Components/CardComentario.vue';

const isSidebarOpen = ref(true);

const formData = ref({
    name: '',
    description: '',
    latitude: '',
    longitude: ''
});

const submitForm = () => {
    axios.post('/crearrestaurante', {
        name: formData.value.name,
        description: formData.value.description,
        latitude: formData.value.latitude,
        longitude: formData.value.longitude
    })
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.error(error);
        });
};

const Restaurante = ref([]);
const comentarios = ref([]);

onMounted(() => {
    axios.get('/restaurantes')
        .then(response => {
            if (response.data.Restaurante) {
                Restaurante.value = response.data.Restaurante;
                console.log(Restaurante.value)

            } else {
                console.error('No Restaurante key in response:', response.data);
            }
        })
        .catch(error => {
            console.error('Error al cargar los restaurantes:', error);
        });

    axios.get('/comentarios')
        .then(response => {
            if (response.data.comentarios) {
                comentarios.value = response.data.comentarios;
                console.log(comentarios.value)

            } else {
                console.error('No comentarios key in response:', response.data);
            }
        })
        .catch(error => {
            console.error('Error al cargar los comentarios:', error);
        });
});

</script>
<template>
    <AuthenticatedLayout>
        <div class="flex flex-wrap min-h-screen">
            <div class="w-full sm:w-1/2 lg:w-1/4 bg-cyan-200 p-6">
                <h3>Crear Restaurante</h3>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text" id="name" v-model="formData.name" class="form-input w-full">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea id="description" v-model="formData.description"
                            class="form-textarea w-full"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="latitude" class="block text-gray-700 font-bold mb-2">Latitude</label>
                        <input type="text" id="latitude" v-model="formData.latitude" class="form-input w-full">
                    </div>
                    <div class="mb-4">
                        <label for="longitude" class="block text-gray-700 font-bold mb-2">Longitude</label>
                        <input type="text" id="longitude" v-model="formData.longitude" class="form-input w-full">
                    </div>
                    <button type="submit"
                        class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </form>
            </div>

            <div class="w-full sm:w-1/2 lg:w-1/2 bg-cyan-200 p-6 overflow-y-auto">
                Tus restaurantes
                <div v-for="Restaurant in Restaurante" :key="Restaurant.id">
                    <CardRestaurante :Restaurant="Restaurant"></CardRestaurante>
                    <br>
                </div>
            </div>

            <div class="w-full sm:w-1/2 lg:w-1/4 bg-cyan-200 p-6 overflow-y-auto" style="height: 700px">
                <h3>Tus comentarios</h3>
                <div v-for="comentario in comentarios" :key="comentario.id">
                    <CardComentarios :comentario="comentario"></CardComentarios>
                    <br>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
