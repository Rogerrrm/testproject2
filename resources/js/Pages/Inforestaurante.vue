<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, nextTick } from 'vue'
import APusers from '@/Components/APusers.vue'
import { defineProps } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';


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
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex h-screen">
            <div class="w-1/4 bg-blue-200 p-6">
                {{ propsrestaurante }}
            </div>


            <div class="w-2/4 bg-gray-200 flex items-center justify-center">
                <form @submit.prevent="submitForm" class="p-4 bg-white rounded-lg shadow-md">
                    <div class="mb-4">
                        <label for="rating" class="block text-gray-700 font-bold mb-2">Rating:</label>
                        <input type="number" id="rating" v-model="formData.rating" min="1" max="5" required>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                        <textarea id="comment" v-model="formData.comment" class="form-textarea w-full h-24"></textarea>
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </form>
            </div>


            <div class="w-1/4 bg-green-200 flex items-center justify-center">Derecha</div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Estilos para las estrellas */
input[type="radio"].sr-only+label svg {
    display: none;
}
</style>
