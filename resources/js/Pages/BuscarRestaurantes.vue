<!-- <template>
    <div class="container mx-auto mt-8">
        <div class="flex justify-center items-center mb-8">
            <label for="stars" class="mr-4">Selecciona las estrellas:</label>
            <select v-model="selectedStars" id="stars" class="px-4 py-2 border rounded" @change="searchRestaurants">
                <option value="1">1 Estrella</option>
                <option value="2">2 Estrellas</option>
                <option value="3">3 Estrellas</option>
                <option value="4">4 Estrellas</option>
                <option value="5">5 Estrellas</option>
            </select>
        </div>

        <div class="w-full map-container">
            <div id="map" class="map-inner-container"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watchEffect } from 'vue';
import axios from 'axios';
import L from 'leaflet';
const restaurants = ref([]);

function searchRestaurants(userId) {
    axios.get('/restaurant')
        .then(response => {
            if (response.data.Restaurante) {
                restaurantes.value = response.data.Restaurante;
                console.log(restaurantes.value);
                watchEffect(() => {
                    updateMapWithEvents();
                });
            } else {
                console.error('No se encontró la clave "Restaurante" en la respuesta:', response.data);
            }
        })
        .catch(error => {
            console.error('Error al cargar los restaurantes:', error);
        });
};

onMounted(searchRestaurants);


const selectedStars = ref(1);
let mapInstance;

onBeforeUnmount(() => {
    if (mapInstance) {
        mapInstance.remove();
    }
});

// const restaurantes = ref([]);

// onMounted(() => {
//     axios.get('/restaurant')
//         .then(response => {
//             if (response.data.Restaurante) {
//                 restaurantes.value = response.data.Restaurante;
//                 console.log(restaurantes.value);
//                 watchEffect(() => {
//                     updateMapWithEvents();
//                 });
//             } else {
//                 console.error('No se encontró la clave "Restaurante" en la respuesta:', response.data);
//             }
//         })
//         .catch(error => {
//             console.error('Error al cargar los restaurantes:', error);
//         });
// });

// function updateMapWithEvents() {
//     if (mapInstance) {
//         mapInstance.remove();
//     }
//     mapInstance = L.map('map').setView([42.2664500, 2.9616300], 13);
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: 'Barbacoas'
//     }).addTo(mapInstance);

//     const filteredRestaurants = restaurantes.value.filter(restaurante => {
//         return restaurante.stars >= selectedStars.value;
//     });
//     console.log(filteredRestaurants)
//     filteredRestaurants.forEach(restaurante => {
//         const lat = restaurante.latitude;
//         const long = restaurante.longitude;
//         const title = restaurante.title;
//         const desc = restaurante.description;
//         const images = restaurante.images;

//         let imgHTML = '';
//         images.forEach(image => {
//             imgHTML += `<img src="${image}" style="max-width: 100px; max-height: 100px; margin: 5px;">`;
//         });

//         const popupContent = `<b>${title}</b><br>${desc}<br>${imgHTML}`;

//         const marker = L.marker([lat, long]).addTo(mapInstance);
//         marker.bindPopup(popupContent);
//     });

//     // Ajusta el tamaño del mapa después de agregar los marcadores
//     mapInstance.invalidateSize();

//     // Escucha el evento de cambio de tamaño del contenedor
//     window.addEventListener('resize', () => {
//         mapInstance.invalidateSize();
//     });
// }

</script>

<style scoped>
/* Estilos específicos para este componente */
.map-container {
    width: 100%;
    height: 400px;
}

.map-inner-container {
    width: 100%;
    height: 100%;
}
</style> -->
<template>
    <AuthenticatedLayout>
        <div class="h-screen container mx-auto mt-8 p-">
            <div class="flex justify-center items-center mb-8">
                <label for="stars" class="mr-4">Selecciona las estrellas:</label>
                <select v-model="selectedStars" id="stars" class="px-4 py-2 border rounded"
                    @change="searchRestaurants(selectedStars)">
                    <option value="1">1 Estrella</option>
                    <option value="2">2 Estrellas</option>
                    <option value="3">3 Estrellas</option>
                    <option value="4">4 Estrellas</option>
                    <option value="5">5 Estrellas</option>
                </select>
            </div>
            <div v-for="restaurante in restaurantes" :key="restaurante.id"
                class="flex justify-center items-center w-full p-6">
                <CardBuscador :restaurante="restaurante"></CardBuscador>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';
import CardBuscador from '@/Components/CardBuscador.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const selectedStars = ref(1);
const restaurantes = ref([]);

const searchRestaurants = (stars) => {
    axios.get(`/restaurant?stars=${stars}`)
        .then(response => {
            if (response.data.Restaurante) {
                restaurantes.value = response.data.Restaurante;
                console.log(restaurantes.value);
            } else {
                console.error('No se encontró la clave "Restaurante" en la respuesta:', response.data);
            }
        })
        .catch(error => {
            console.error('Error al cargar los restaurantes:', error);
        });
};

// Llamada inicial para cargar los restaurantes con la cantidad de estrellas seleccionada inicialmente
searchRestaurants(selectedStars.value);
</script>