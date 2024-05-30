<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, nextTick } from 'vue'
import APusers from '@/Components/APusers.vue'
import { defineProps } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useRouter } from 'vue-router';


// define props de los eventos
const page = usePage();
const propsrestaurante = page.props.Restaurant;

console.log("Restaurante ", page.props.Restaurant);


const formData = ref({
    rating: null,
    comment: ''
});

const submitForm = () => {
    axios.post('/ratings', {
        rating: formData.value.rating,
        comment: formData.value.comment,
        restaurant_id: propsrestaurante.id // Aquí deberías reemplazar 1 por el ID del restaurante adecuado
    })
        .then(response => {
            console.log(response.data);
            // Aquí podrías mostrar un mensaje de éxito o redirigir a otra página
        })
        .catch(error => {
            console.error(error);
            // Aquí podrías mostrar un mensaje de error al usuario
        });
};

const commentarios = ref([]);

axios.get(`/comentarios_restaurante/${propsrestaurante.id}`)
    .then(response => {
        console.log(response.data);
        commentarios.value = response.data;
        // Aquí puedes acceder a los comentarios y a los nombres de usuario en la respuesta
    })
    .catch(error => {
        console.error(error);
        // Aquí puedes manejar cualquier error que ocurra durante la solicitud
    });

import L from 'leaflet';

// const map = ref(null);

// onMounted(() => {
//     createMap();
// });

// function createMap() {
//     map.value = L.map('map').setView([42.2765, 2.965], 13); // La latitud y longitud del restaurante se establecen como el centro del mapa

//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
//     }).addTo(map.value);

//     const restauranteMarker = L.marker([propsrestaurante.latitude, propsrestaurante.longitude]).addTo(map.value); // Marcador en la ubicación del restaurante
//     restauranteMarker.bindPopup('<b>Restaurante:</b> Restaurante 2<br><b>Descripción:</b> dfdfdadvdsdvcxz').openPopup();
// }
const openGoogleMaps = () => {
    const router = useRouter();
    const lat = propsrestaurante.latitude;
    const lon = propsrestaurante.longitude;
    // Genera el enlace de Google Maps con las coordenadas
    const googleMapsLink = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
    // Redirige a la página de Google Maps
    window.location.href = googleMapsLink;
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-col h-screen">
            <!-- Parte Superior: Información del Restaurante -->
            <div class="w-full bg-blue-200 p-6">
                <h2 class="text-lg font-bold mb-4">Restaurante</h2>
                <div>
                    <p><strong>Nombre:</strong> {{ propsrestaurante.name }}</p>
                    <p><strong>Descripción:</strong> {{ propsrestaurante.description }}</p>
                    <p><strong>Ubicación:</strong> {{ propsrestaurante.latitude }}, {{ propsrestaurante.longitude }}</p>
                    <p><strong>Calificación Promedio:</strong> {{ propsrestaurante.average_rating }}</p>
                    <p><strong>Creado el:</strong> {{ new Date(propsrestaurante.created_at).toLocaleString() }}</p>
                    <p><strong>Actualizado el:</strong> {{ new Date(propsrestaurante.updated_at).toLocaleString() }}</p>
                </div>
            </div>

            <!-- Parte Inferior: Comentarios y Más Información -->
            <div class="flex flex-grow">
                <!-- Comentarios -->
                <div class="w-1/2 bg-gray-100 flex items-center justify-center p-6">
                    <form @submit.prevent="submitForm" class="w-full max-w-lg bg-white rounded-lg shadow-md p-6">
                        <div class="mb-4">
                            <label for="rating" class="block text-gray-700 font-bold mb-2">Rating:</label>
                            <input type="number" id="rating" v-model="formData.rating" min="1" max="5" required
                                class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                            <textarea id="comment" v-model="formData.comment"
                                class="form-textarea mt-1 block w-full h-24 border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <button type="submit"
                            class="bg-blue-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    </form>
                </div>

                <!-- Más Información -->
                <div class="w-1/2 bg-green-200 p-6 flex items-start justify-center">
                    <div class="w-full border">
                        <h2 class="text-lg font-bold mb-4">Más Información</h2>
                        <!-- <div id="map" class="leaflet-map"></div> -->
                        <p>Si necesitas mas datos sobre la localizacion del lugar por aqui te dejo el acceso al mapa</p>
                        <button @click="openGoogleMaps"
                            class="bg-blue-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver en Google
                            Maps</button>

                        <div><br>
                            <h2>Comentarios</h2>
                            <div v-for="comentario in commentarios" :key="comentario.id"
                                class="border-2 border-cyan-800 mb-2">
                                Hecho por: {{
                                    comentario.user.name }} ha valorado con: {{ comentario.rating }} estrellas, su
                                comentario: {{ comentario.comment }} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
#map {
    height: 10px !important;
}


/* Estilos para las estrellas */
input[type="radio"].sr-only+label svg {
    display: none;
}
</style>
