import { ref } from "vue";
import axios from "axios";

const permissions = ref([]); // 🔹 Reactive state

const fetchPermissions = async () => {
    const token = localStorage.getItem("auth_token");
    if (!token) return;

    try {
        const headers = { Authorization: `Bearer ${token}` };
        const response = await axios.get("/api/get_function_available_by_role", { headers });

        permissions.value = response.data.function || []; // 🔹 Update reactive state
    } catch (error) {
        console.error("Unauthorized:", error);
    }
};

const checkPermission = (name) => {
    return permissions.value.some((item) => item.name === name);
};

export { permissions, fetchPermissions, checkPermission };
