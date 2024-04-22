<template>
    <div class="carousel">
        <div class="carousel-items">
            <div class="carousel-item"><img src="../../../public/img/logo.jpg" alt=""></div>
            <div class="carousel-item"><img src="../../../public/img/logo.jpg" alt=""></div>
            <div class="carousel-item"><img src="../../../public/img/logo.jpg" alt=""></div>
        </div>
        <button onclick="previous()">Previous</button>
        <button onclick="next()">Next</button>
    </div>
</template>
<style>
.carousel-items {
    display: flex;
    overflow: hidden;
    width: 100%;
}

.carousel-item {
    flex: 0 0 100%;
    order: 1;
}
</style>
<script>

let currentSlide = 0;
const items = document.querySelectorAll('.carousel-item');

function showSlide(index) {
    items.forEach((item, idx) => {
        item.style.transform = `translateX(-${index * 100}%)`;
    });
}

function next() {
    currentSlide = (currentSlide + 1) % items.length;
    showSlide(currentSlide);
}

function previous() {
    currentSlide = (currentSlide - 1 + items.length) % items.length;
    showSlide(currentSlide);
}

document.addEventListener('DOMContentLoaded', () => {
    showSlide(currentSlide);
});
</script>