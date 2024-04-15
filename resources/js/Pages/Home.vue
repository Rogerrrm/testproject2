<script setup>
import navbar from "@/Components/Navbar.vue";
import { Carousel } from "flowbite";
import { ref, defineProps, onMounted } from 'vue';
import carousel from "@/Components/carousel.vue";
import cookies from "@/Components/cookies.vue";

const props = defineProps({
    usuarios: Array
});


const Usuarios = ref();

axios.get('/buscarusuarios')
    .then(response => {
        Usuarios.value = response.data;
        console.log("Datos de Usuarios:", Usuarios.value);
    })
    .catch(error => {
        console.error('Error al obtener las Usuarios:', error);
    });

const Cursos = ref();

axios.get('/buscarcursos')
    .then(response => {
        Cursos.value = response.data;
        console.log("Datos de Cursos:", Cursos.value);
    })
    .catch(error => {
        console.error('Error al obtener las Cursos:', error);
    });
</script>

<template>
    <div>
        <navbar></navbar>
        <div class="text-center">
            <p class="bg-blue-300 p-2 rounded-lg">¡Bienvenido!</p>
            <p class="mt-4">Explora un universo de aprendizaje en nuestra institución educativa, donde cada jornada es
                un viaje hacia el saber y el desarrollo personal.</p>
        </div>


        <carousel></carousel>
        <br>

        <div v-for="curso in Cursos" :curso.id class="text-center">
            <h1 class="text-2xl font-bold mb-4">Lista de Cursos</h1>
            <ul v-if="curso.length > 0">
                <li v-for="curs in curso" :key="curs.id" class="mb-6">
                    <h2 class="text-xl font-semibold">{{ curs.nombre }}</h2>
                    <p><strong>Etapa:</strong> {{ curs.etapa }}</p>
                    <p><strong>Descripción:</strong> {{ curs.descripcion }}</p>
                </li>
            </ul>
            <p v-else>No hay cursos disponibles.</p>
        </div>
    </div>
    <cookies></cookies>
</template>