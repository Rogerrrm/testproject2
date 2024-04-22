<template>
    <div class="carousel">
        <div class="carousel-items" ref="carousel">
            <div class="carousel-item" v-for="item in items" :key="item.id">
                <img :src="item.src" :alt="item.alt">
            </div>
        </div>
        <button @click="previous">Previous</button>
        <button @click="next">Next</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentSlide: 0,
            items: [
                { id: 1, src: '../../../public/img/logo.jpg', alt: 'Logo 1' },
                { id: 2, src: '../../../public/img/logo.jpg', alt: 'Logo 2' },
                { id: 3, src: '../../../public/img/logo.jpg', alt: 'Logo 3' },
            ]
        };
    },
    methods: {
        showSlide(index) {
            const carousel = this.$refs.carousel;
            if (carousel) {
                carousel.style.transform = `translateX(-${index * 100}%)`;
            }
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.items.length;
            this.showSlide(this.currentSlide);
        },
        previous() {
            this.currentSlide = (this.currentSlide - 1 + this.items.length) % this.items.length;
            this.showSlide(this.currentSlide);
        }
    },
    mounted() {
        this.showSlide(this.currentSlide);
    }
}
</script>

<style>
.carousel-items {
    display: flex;
    overflow: hidden;
    width: 100%;
}

.carousel-item {
    flex: 0 0 100%;
}
</style>