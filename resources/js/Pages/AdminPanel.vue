<template>
    <Navbar></navbar>
    holaaaaaaaaa
    <div>
        <div v-for="usuario in usuarios" :key="usuario.id">
            {{ usuario.nombre }}
        </div>
    </div>

    <!-- Personalización del textarea con Tailwind CSS -->
    <textarea class="ckeditor-textarea border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
        name="content" id="editor" placeholder="Escribe aquí..." style="min-height: 200px; width: 200px;"></textarea>
</template>

<script setup>
import { ref, defineProps, onMounted } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    usuarios: Array
});

onMounted(() => {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
});
</script>