<template>
    <nav v-if="isAuthenticated" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid px-8">
            <router-link to="/" class="navbar-brand"> CORE BASSIC</router-link>
            
            <button class="navbar-toggler" type="button" @click="toggleMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div :class="menuClasses" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li v-if="$checkPermission('access_setting') || $checkPermission('access_branch') || $checkPermission('access_role') || $checkPermission('access_user') " class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                            {{ $t('settings') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li v-if="$checkPermission('access_branch')">
                                <router-link  class="dropdown-item" to="branch"><i class="fa fa-angle-double-right"></i>  {{ $t('branch') }}</router-link>
                            </li>
                            <!-- <li>
                                <hr class="dropdown-divider">
                            </li> -->
                            <li v-if="$checkPermission('access_role')">
                                <router-link  class="dropdown-item" to="roles"><i class="fa fa-angle-double-right"></i> {{ $t('role') }}</router-link>
                            </li>
                            <!-- <li>
                                <hr class="dropdown-divider">
                            </li> -->
                            <li v-if="$checkPermission('access_user')">
                                <router-link  class="dropdown-item" to="users"><i class="fa fa-angle-double-right"></i> {{ $t('user') }}</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div>
                    <select @change="$changeLanguage($event)">
                        <option value="la">LA</option>
                        <option value="en">EN</option>
                        <option value="cn">CN</option>
                    </select>
                </div>
                <div class="d-flex">
                    <a href="javascript:void(0)" class="nav-link flex flex-row align-items-center" @click="openModal">
                        <img src="../../public//images/logo.png" style="width: 30px; height: 30px" alt="AdminLTE Logo"
                            class="brand-image img-circle elevation-3 mr-1">
                        Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>
     <!-- modal-logout -->
        <div v-if="showModal" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('logout') }}</h5>
                        <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                         <h2>ທ່ານຕ້ອງການອອກລະບົບບໍ ?</h2>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="closeModal"><i class="fa fa-user"></i> Profile</button>
                        <button type="button" class="btn btn-primary" @click="logout">
                            <i class="fa-solid fa-right-to-bracket"></i>
                             ຕົກລົງ
                        </button>

                    </div>
                </div>
            </div>
        </div>
    <!-- end -->

    <main class="px-8 py-4">
        <router-view></router-view>
    </main>
</template>

<script setup>
import axios from 'axios';
import { ref, computed, onMounted, onUnmounted, getCurrentInstance } from 'vue';
import { fetchPermissions} from '../js/permissionStore.js';

const showModal = ref(false)
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
const instance = getCurrentInstance();
onMounted( async () =>{
    window.addEventListener('resize', updateWidth);
    fetchPermissions();
    //await getFunctionModel();
});

// Remove event listener on unmount
onUnmounted(() => {
    window.removeEventListener('resize', updateWidth);
});

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
const openModal = () => {
    showModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
}
const logout = async () => {
    const token = localStorage.getItem("auth_token");
    if (!token) {
         toast.fire({ icon: "success", title: "ອອກຈາກລະບົບສໍາເລັດແລ້ວ" });
        return;
    }
    try {
        await axios.post('/api/logout', {}, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json", // Important to prevent CSRF check
            }
        });
        localStorage.removeItem("auth_token");
        toast.fire({ icon: "success", title: "ອອກຈາກລະບົບສໍາເລັດແລ້ວ" });
        window.location.href = "/login";
    } catch (error) {
        console.error("Logout failed:", error.response?.data || error.message);
    }
};
</script>
