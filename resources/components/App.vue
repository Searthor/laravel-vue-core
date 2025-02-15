<template>
    <nav v-if="isAuthenticated" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid px-8">
            <router-link to="/" class="navbar-brand"> CORE BASSIC</router-link>
            
            <button class="navbar-toggler" type="button" @click="toggleMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div :class="menuClasses" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ຕັ້ງຄ່າລະບົບ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <router-link  class="dropdown-item" to="branch">ສາຂາ</router-link>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <router-link  class="dropdown-item" to="roles">ສິດນໍາໃຊ້</router-link>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">ຜູ້ໃຊ້ລະບົບ</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <a class="nav-link flex ">

                        <img src="../../public//images/logo.png" style="width: 30px; height: 30px" alt="AdminLTE Logo"
                            class="brand-image img-circle elevation-3">
                        Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="px-8 py-4">
        <router-view></router-view>
    </main>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const isMenuOpen = ref(false);
const windowWidth = ref(window.innerWidth);
const isAuthenticated = computed(() => !!localStorage.getItem("auth_token"));
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
