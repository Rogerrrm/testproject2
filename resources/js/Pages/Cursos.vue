<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, nextTick } from 'vue'
import APusers from '@/Components/APusers.vue'
import { defineProps } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { onMounted } from 'vue';
import editor from '@/Components/editor.vue'
import formcursos from '@/Components/formcursos.vue';
import APcursos from '@/Components/APcursos.vue';
import formrecursos from '@/Components/formrecursos.vue';
import APrecursos from '@/Components/APrecursos.vue';

const isSidebarOpen = ref(true);

function toggleSidebar() {
    console.log("Botón de la barra lateral clicado");
    isSidebarOpen.value = !isSidebarOpen.value;
}

let users_ = ref(false)
let informes_ = ref(false)
let categorias_ = ref(false);
let recursos_ = ref(false);
let recursosgrupos_ = ref(true);

function users() {
    users_.value = true;
    informes_.value = false;
    categorias_.value = false;
    recursos_ = false;
    recursosgrupos_ = false;
}
function informes() {
    informes_.value = true;
    users_.value = false;
    categorias_.value = false;
    recursos_ = false;
    recursosgrupos_ = false;
}
function categorias() {
    categorias_.value = true;
    informes_.value = false;
    users_.value = false;
    recursos_ = false;
    recursosgrupos_ = false;
}
function recursos() {
    categorias_.value = false;
    informes_.value = false;
    users_.value = false;
    recursos_ = true;
    recursosgrupos_ = false;
}
function recursosgrupos() {
    categorias_.value = false;
    informes_.value = false;
    users_.value = false;
    recursos_ = false;
    recursosgrupos_ = true;
}

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

const Recursos = ref();

axios.get('/buscarrecursos')
    .then(response => {
        Recursos.value = response.data;
        console.log("Datos de Recursos:", Recursos.value);
    })
    .catch(error => {
        console.error('Error al obtener las Recursos:', error);
    });

const selectedGrupo = ref(null);
const recurso = ref([]);

const cargarRecursos = () => {
    // Verifica si se ha seleccionado un grupo
    if (selectedGrupo.value) {
        axios.post('/buscarcursosrecursos', {
            grupoId: selectedGrupo.value
        })
            .then(response => {
                // Almacena los recursos obtenidos en la variable recursos
                recurso.value = response.data.recursos;
                console.log("Recursos obtenidos:", recurso.value);
            })
            .catch(error => {
                // Maneja el error si es necesario
                console.error(error);
            });
    } else {
        console.log('Por favor, selecciona un grupo antes de cargar los recursos.');
    }
};

onMounted(() => {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
        });
});
</script>

<template>
    <AuthenticatedLayout>
    </AuthenticatedLayout>
    <div>
        <button @click="toggleSidebar" type="button"
            class="block sm:hidden fixed top-4 left-4 z-50 bg-gray-200 p-2 rounded-lg">
            <span class="sr-only">Abrir menú</span>
            <!-- Ícono para abrir el menú -->
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 4.5A1.5 1.5 0 0 1 4.5 3h11A1.5 1.5 0 0 1 17 4.5v11a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 15.5v-11zm1-2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-11a2 2 0 0 0-2-2h-11z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>


        <!-- Barra lateral -->
        <aside id="separator-sidebar" :class="{ 'hidden': !isSidebarOpen }"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidebar">

            <Head />

            <div class="h-full px-3 py-4 overflow-y-auto bg-header dark:bg-gray-800">
                <ul class="space-y-2 font-medium main_ul">
                    <a href="/home">
                        <li>
                            <img src="../../../public/img/logo.jpg" alt="logo" class="w-20 h-20 rounded-full">

                        </li>
                    </a>
                    <li v-on:click="recursosgrupos">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5  transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 20">
                                <path
                                    d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap ">Grupos y Recursos</span>
                        </a>
                    </li>
                    <li v-on:click="informes">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5  transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap ">Cursos</span>
                            <span
                                class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                        </a>
                    </li>

                    <li v-on:click="users">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5  transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 18">
                                <path
                                    d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap ">Mis cursos</span>
                        </a>
                    </li>
                    <li v-on:click="categorias">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5  transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 20">
                                <path
                                    d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap ">Recursos</span>
                        </a>
                    </li>
                    <li v-on:click="recursos">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5  transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 20">
                                <path
                                    d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap ">Mis Recursos</span>
                        </a>
                    </li>
                </ul>
            </div>

        </aside>
    </div>
    <div class="p-4 sm:ml-64">

        <!--  -->

        <div v-if="informes_">
            <p>Crear Cursos</p>
            <formcursos></formcursos>
        </div>
        <!--  -->

        <div v-if="users_">
            <div v-for="curso in Cursos" :key="curso.id">
                <div v-for="curs in curso" :key="curs.id">
                    <APcursos :cursos="curs"></APcursos>
                </div>
            </div>

        </div>
        <!--  -->

        <div v-if="categorias_">
            <div v-for="curso in Cursos" :key="curso.id">
                <formrecursos :cursos="curso"></formrecursos>
            </div>
        </div>

        <div v-if="recursos_">
            <div v-for="recurso in Recursos" :key="recurso.id">
                <div v-for="recurs in recurso" :key="recurs.id">
                    <APrecursos :recursos="recurs"></APrecursos>
                </div>
            </div>
        </div>

        <div v-if="recursosgrupos_">
            Selecciona un curso
            <div v-for="curso in Cursos" :key="curso.id">
                <select v-model="selectedGrupo" @change="cargarRecursos">
                    <option value="">Selecciona un grupo</option>
                    <option v-for="curs in curso" :key="curs.id" :value="curs.id">{{ curs.nombre }}</option>
                </select>
            </div>

            <div>
                <div v-show="recurso.length > 0">
                    <div v-for="recurs in recurso" :key="recurs.id">
                        <br>
                        <APrecursos :recursos="recurs"></APrecursos>
                    </div>
                </div>
                <div v-show="recurso.length === 0">
                    No hay recursos disponibles.
                </div>
            </div>
        </div>


    </div>
</template>
