<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Login</h2>
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" v-model="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="text-danger mt-3" v-if="errorMessage">{{ errorMessage }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const phone = ref("");
const password = ref("");
const errorMessage = ref("");
const router = useRouter();
const login = async () => {
    try {
        console.log(phone.value,password.value)
        const formData = new FormData();
        formData.append('phone', phone.value);
        formData.append('password', password.value);
            const response = await axios.post("api/login", formData,{
            headers: {
                Accept: "application/json",
            }
            });
            if (response.data.success) {
                localStorage.setItem("auth_token", response.data.token);
                toast.fire({ icon: "success", title: "ເຂົ້າລະບົບສໍາເລັດແລ້ວ" });
                window.location.href = "/";
            }
    } catch (error) {
        console.log(error)
        // errorMessage.value = "Invalid credentials!";
    }
};
// const login = async () => {
//     try {
//         console.log(phone.value, password.value);
//         const formData = new FormData();
//         formData.append('phone', phone.value);
//         formData.append('password', password.value);
//         // Then send the login request
//         axios.get('/sanctum/csrf-cookie', { withCredentials: true }).then( async () => {
//                 const response = await axios.post("api/login", formData, {
//                     headers: {
//                         Accept: "application/json",
//                         //Content-Type: "application/json"
//                     }
//                 });
//                 // If login is successful, store the token and redirect
//                 if (response.data.success) {
//                     localStorage.setItem("auth_token", response.data.token);
//                     window.location.href = "/";
//                 }
//         })
//     } catch (error) {
//         console.log("Error during login:", error);
//         // Optionally, set an error message
//         // errorMessage.value = "Invalid credentials!";
//     }
// };
</script>
