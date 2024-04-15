<template>
    <div v-if="showCookiePopup" class="fixed bottom-0 left-0 w-full bg-gray-900 text-white p-4">
        <p class="mb-2">Este sitio web utiliza cookies para mejorar la experiencia del usuario.</p>
        <div class="flex justify-end">
            <button class="bg-green-500 text-white px-4 py-2 mr-2 rounded hover:bg-green-600"
                @click="acceptCookies">Aceptar</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                @click="rejectCookies">Denegar</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const showCookiePopup = ref(true);

const acceptCookies = () => {
    showCookiePopup.value = false;
};

const rejectCookies = () => {
    showCookiePopup.value = false;
};

</script>