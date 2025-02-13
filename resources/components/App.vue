<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CORE BASSIC</a>
            <button class="navbar-toggler" type="button" @click="toggleMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div :class="menuClasses" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link active" to="/">
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link " to="/product">
                            Product
                        </router-link>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="p-4">
        <router-view></router-view>
    </main>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const isMenuOpen = ref(false);
const windowWidth = ref(window.innerWidth);

// Function to update window width
const updateWidth = () => {
    windowWidth.value = window.innerWidth;
};

// Compute classes dynamically based on screen size
const menuClasses = computed(() => {
    return {
        'collapse navbar-collapse': windowWidth.value < 992 && !isMenuOpen.value, // `md` and below
        'navbar-collapse': windowWidth.value >= 992 || isMenuOpen.value, // `lg` and above
    };
});

// Add event listener to detect screen resize
onMounted(() => {
    window.addEventListener('resize', updateWidth);
});

// Remove event listener on unmount
onUnmounted(() => {
    window.removeEventListener('resize', updateWidth);
});

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>
