<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import { defineProps } from 'vue';

const props = defineProps({
    comentario: Object,
});

const editing = ref(false);

const submitEdit = () => {
    axios.put(`/editcomentarios/${props.comentario.id}`, props.comentario)
        .then(response => {
            editing.value = false;
        })
        .catch(error => {
            console.error('Error al editar el comentario:', error);
        });
};
const eliminarComentario = () => {
    axios.delete(`/deletecomentarios/${props.comentario.id}`)
        .then(response => {
            // Aquí podrías emitir un evento o realizar alguna acción específica después de la eliminación
            // Por ejemplo, redireccionar a otra página o actualizar la lista de comentarios
        })
        .catch(error => {
            console.error('Error al eliminar el comentario:', error);
        });
};
</script>

<template>
    <div v-if="props.comentario"
        class="w-full bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                <p>Restaurante: {{ props.comentario.restaurant_name }}</p>
                <p>Echo por {{ props.comentario.user_name }}</p>
                <p>Valoracion {{ props.comentario.rating }} estrellas</p>
            </h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Comentario: {{ props.comentario.comment }}</p>
            <button @click="editing = !editing" class=" text-blue-800 hover:text-blue-700">Editar</button>
            <button @click="eliminarComentario"
                class="ml-20 bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
            <form v-if="editing" @submit.prevent="submitEdit">
                <label for="rating" class="block mb-1">Valoración:</label>
                <input v-model="props.comentario.rating" type="number" min="1" max="5" class="form-input mb-3">
                <label for="comment" class="block mb-1">Comentario:</label>
                <textarea v-model="props.comentario.comment" class="form-textarea mb-3"></textarea>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
            </form>
        </div>
    </div>
</template>