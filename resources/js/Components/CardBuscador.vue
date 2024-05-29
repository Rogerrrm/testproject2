<template>

    <div>
        <div v-if="restaurante"
            class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <div class="p-4 leading-normal">
                <h5 class="flex justify-between mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <p class="m-2"> Restaurante: {{ props.restaurante.name }}</p>
                    <p class="m-2">Restaurante: {{ props.restaurante.description }}</p>
                    <p class="m-2">Restaurante: {{ props.restaurante.latitude }} {{ props.restaurante.longitude }}</p>
                </h5>
            </div>
            <Link :href="route('inforestaurante', { id: restaurante.id })" :restaurante="restaurante">
            <button type="button"
                class="flex justify-center items-center focus:outline-none text-white  bg-purple-600 hover:bg-purple-500 focus:ring-4 focus:ring-purple-600 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-600 dark:focus:ring-purple-600">
                Informacion
            </button>
            </Link>
        </div>
        <!-- <Mapa :restaurante="restaurante" /> -->
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import Mapa from '@/Components/Mapa.vue';

const props = defineProps({
    restaurante: Object,
});
</script>

<style scoped>
/* Estilos opcionales para el componente */
</style>