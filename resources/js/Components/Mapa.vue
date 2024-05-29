<template>
    <div id="map" class="map-container"></div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import L from 'leaflet';

const map = ref(null);

onMounted(() => {
    createMap();
});

function createMap() {
    map.value = L.map('map').setView([42.2765, 2.965], 10); // La latitud y longitud del restaurante se establecen como el centro del mapa

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map.value);

    const restauranteMarker = L.marker([42.2765, 2.965]).addTo(map.value); // Marcador en la ubicación del restaurante
    restauranteMarker.bindPopup('<b>Restaurante:</b> Restaurante 2<br><b>Descripción:</b> dfdfdadvdsdvcxz').openPopup();
}
</script>

<style scoped>
.map-container {
    height: 100px;
    /* Ajusta la altura según tus necesidades */
}
</style>