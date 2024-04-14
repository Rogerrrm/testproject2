<script setup>
import { ref, onMounted } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import axios from 'axios';

const Usuarios = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/buscarusuarios');
        Usuarios.value = response.data;
        console.log("Datos de Usuarios:", Usuarios.value);

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                const usuariosHTML = Usuarios.value.map(user => `<li>${user.name}</li>`).join('');
                editor.setData(`<ul>${usuariosHTML}</ul>`);
            })
            .catch(error => {
                console.error(error);
            });
    } catch (error) {
        console.error('Error al obtener las Usuarios:', error);
    }
});
</script>

<template>
    <h2>Editor WYSIWYG</h2>
    <div id="editor" placeholder="Escribe aquí..."></div>
</template>
