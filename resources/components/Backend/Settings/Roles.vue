<template>
    <div class="row page-titles mx-0 px-4">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <p>ສິດນໍາໃຊ້ລະບົບ</p>
            </div>
        </div>
        <div class="col-sm-6  justify-content-sm-end  d-flex">
            <a>Dashboard</a>
        </div>
    </div>

    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-header p-3 " style="background: gray;">
                <div class="row w-100">
                    <div class="col-md-3">
                        <input class="form-control" placeholder="Search..."></input>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option value="10">10</option>
                            <option value="30">30</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn" @click="openModal">ເພີ່ມໃໝ່</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- <div v-if="isLoading" class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div> -->
                <div class="table-responsive">
                    <table class="table table-responsive-sm">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">ຊື່</th>
                                <th scope="col">ລາຍລະອຽດ</th>
                                <th scope="col">ຈັດການ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="roles in rolesList" :key="roles.id">
                                <td>{{ roles.id }}</td>
                                <td>{{ roles.name }}</td>
                                <td>{{ roles.des }}</td>
                                <td>
                                    <button class="btn btn-success" @click="UpdateRoles(roles.id)">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger ml-2" @click="openModaldelete(roles.id)">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="pagination">
                    <a href="#" class="btn" v-for="(link, index) in links" :key="index" v-html="link.label"
                        :class="{ active: link.active, disabled: !link.url }" @click="changePage(link)"></a>
                </div> -->
            </div>
        </div>
    </div>
    <div v-if="showModal" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ form.id ? 'ເພີ່ມສິດ' : 'ແກ້ໄຂສິດ' }}</h5>
                    <button type="button " class="btn btn-danger" @click="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ຊື່</label>
                                    <input type="text" class="form-control" v-model="form.name" placeholder="ຊື່">
                                    <span class="text-danger" v-if="errors.name">{{ errors.name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ລາຍລະອຽດ</label>
                                    <input type="text" class="form-control" v-model="form.des" placeholder="ລາຍລະອຽດ">

                                </div>
                            </div>
                        </div>
                        <div v-for="parent in functionModelList" :key="parent.id">

                            <!-- Parent checkbox: click toggles parent selection -->
                            <label class="mt-4">
                                <input type="checkbox" :value="parent.id" v-model="selectedItems"
                                    @click="selectParent(parent.id)" class="checkbox-custom" />
                                {{ parent.des }}
                            </label>
                            <!-- Show children if the parent is selected -->
                            <template v-if="selectedParents.includes(parent.id)">
                                <!-- Loop through each child -->
                                <div class="mt-1" v-for="child in parent.children" :key="child.id">

                                    <label class="w-100 mt-1">
                                        <input type="checkbox" :value="child.id" v-model="selectedItems"
                                            @click="onChildClick(child.id)" class="checkbox-custom child-checkbox" />
                                        {{ child.des }}
                                    </label>
                                    <!-- <div class="grandchild-checkbox mt-2" v-for="child in parent.children" :key="child.id"> -->
                                    <div class=" grandchild-checkbox flex justify-between"
                                        v-if="selectedItems.includes(child.id)">
                                        <div v-for="grandchild in child.grandchildren" :key="grandchild.id">
                                            <label>
                                                <input type="checkbox" :value="grandchild.id" v-model="selectedItems"
                                                    class="checkbox-custom" />
                                                {{ grandchild.des }}
                                            </label>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <!-- For each child that is selected, show its grandchildren -->
                            </template>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">ປິດ</button>
                    <button type="button" class="btn btn-primary" @click="submitForm">
                        {{ form.id ? 'ແກ້ໄຂ' : 'ບັກທືກ' }}
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div v-if="showModaldelete" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-between bg-danger">
                    <h5 class="modal-title text-white">ລົບ</h5>
                    <button type="button" class="btn btn-light" @click="closeModaldDetele()">&times;</button>
                </div>
                <div class="modal-body">
                    <h1 class="text-center text-xl font-bold">Do you want to delete?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModaldDetele()">ປິດ</button>
                    <button type="button" class="btn btn-danger" @click="deleteRole()">ລົບ</button>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-danger" @click="logout()">logout</button>

</template>


<script setup>

import axios from 'axios';
import { onMounted, onUpdated, ref } from 'vue';

const showModal = ref(false)
const showModaldelete = ref(false)
const errors = ref({})
var deleteID = '';


const functionModelList = ref([]);
const rolesList = ref([]);

// Reactive array to hold the IDs of selected parents
const selectedParents = ref([]);

// Reactive array to hold the IDs of selected items (children and grandchildren)
const selectedItems = ref([]);

/**
 * When a parent checkbox is clicked, toggle its selection.
 */
const selectParent = (id) => {
    if (selectedParents.value.includes(id)) {
        // Deselect parent

        selectedParents.value = selectedParents.value.filter(parentId => parentId !== id);
        // Deselect all children and grandchildren of this parent
        const parent = functionModelList.value.find(p => p.id === id);
        if (parent) {
            selectedItems.value = selectedItems.value.filter(itemId => {
                return !parent.children.some(child => child.id === itemId || child.grandchildren.some(grandchild => grandchild.id === itemId));
            });
        }
        selectedItems.value = selectedItems.value.filter(itemId => itemId !== id);
    } else {
        // Select parent
        selectedParents.value.push(id);
        selectedItems.value.push(id);
    }
    console.log(selectedItems.value)
};

/**
 * Custom logic for when a child checkbox is clicked.
 */
const onChildClick = (childId) => {
    const child = functionModelList.value
        .flatMap(parent => parent.children)
        .find(c => c.id === childId);

    if (!child) return;

    const grandchildIds = child.grandchildren ? child.grandchildren.map(g => g.id) : [];

    if (selectedItems.value.includes(childId)) {
        // Deselect child and all grandchildren
        selectedItems.value = selectedItems.value.filter(itemId => itemId !== childId && !grandchildIds.includes(itemId));
    } else {
        // Select child
        selectedItems.value.push(childId);
    }

    console.log(selectedItems.value);
};


const resetform = () => {
    form.value.name = '';
    form.value.id = '';
    form.value.des = '';

    selectedParents.value = [];  // Correct way to clear a ref
    selectedItems.value = [];    // Correct way to clear a ref
};

const openModal = () => {
    resetform();
    showModal.value = true;
};


const form = ref({
    name: '',
    des: '',
});

const closeModal = () => {
    showModal.value = false;
}
// const logout = async () => {
//     const token = localStorage.getItem("auth_token");
//     const headers = {
//         Authorization: `Bearer ${token}`,
//         Accept: "application/json", // 👈 Important to prevent CSRF check
//     };
//     await axios.post('/logout', { headers });
// }
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


const validateForm = () => {
    errors.value = {}
    if (!form.value.name) errors.value.name = "name is required.";
    return Object.keys(errors.value).length === 0;
}

const getFunctionModel = async () => {
    try {
        const token = localStorage.getItem("auth_token");

        const headers = {
            Authorization: `Bearer ${token}`
        };

        const response = await axios.get("/api/function_models", { headers });
        functionModelList.value = response.data.function;
        console.log(response)
    } catch (error) {
        console.error("Unauthorized:", error);
        // if (error.response.status === 401) {
        //     window.location.href = "/login"; // Redirect if unauthorized
        // }
    }
};

const getRoles = async () => {
    try {
        const token = localStorage.getItem("auth_token");

        const headers = {
            Authorization: `Bearer ${token}`
        };
        const response = await axios.get('/api/roles', { headers });
        rolesList.value = response.data.roles;
        console.log(rolesList);
    } catch (error) {
        console.error('Error fetching function model:', error);
    }
};

onMounted(async () => {
    await getFunctionModel();
    await getRoles();
    // alert(productTypes.length)
})
const submitForm = async () => {
    if (!validateForm()) return;
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('des', form.value.des);
    selectedItems.value.forEach(id => {
        formData.append('function_id[]', id);

    });

    try {
        const token = localStorage.getItem("auth_token");

        const headers = {
            Authorization: `Bearer ${token}`,
            Accept: "application/json", // 👈 Important to prevent CSRF check
        };

        // alert(token)

        let response;
        if (form.value.id) {
            response = await axios.post(`/api/update_roles/${form.value.id}`, formData, { headers });
            toast.fire({ icon: "success", title: "Updated Successfully" });
        } else {
            response = await axios.post("/api/create_roles", formData,{ headers });
            toast.fire({ icon: "success", title: "ເພີ່ມສິດສໍາເລັດແລ້ວ" });
        }
        closeModal();
        getRoles();
        console.log("Response:", response);
    } catch (error) {
        console.error("Error:", error.response?.data || error.message);
        toast.fire({ icon: "error", title: "ມີຂໍ້ຜິດພາດ, ກະລຸນາລອງໃໝ່!" });
    }


}
const UpdateRoles = async (id) => {
    const token = localStorage.getItem("auth_token");

    const headers = {
        Authorization: `Bearer ${token}`,
        Accept: "application/json", // 👈 Important to prevent CSRF check
    };
    const response = await axios.get(`/api/get_roles/${id}`, { headers });
    form.value.name = response.data.data[0].name;
    form.value.des = response.data.data[0].des;
    form.value.id = response.data.data[0].id;
    selectedItems.value = response.data.data[0].function_id;
    selectedParents.value = response.data.data[0].Parents_id;
    showModal.value = true;
    console.log(response)
}
const deleteRole = async () => {
    try {
        const response = await axios.delete(`/api/roles/${deleteID}`);
        toast.fire({ icon: "success", title: response.data.message });
        closeModaldDetele();
        await getRoles();
    } catch (error) {
        console.error('Error deleting role:', error);
    }
}

const openModaldelete = (id) => {
    deleteID = id
    showModaldelete.value = true
};

const closeModaldDetele = () => {
    deleteID = null
    showModaldelete.value = false
}


</script>

<style scoped>
.table-responsive {
    margin-top: 20px;
}

.table-borderless {
    border: none;
}

.table-borderless th,
.table-borderless td {
    border: none;
}

.checkbox-custom {
    width: 20px;
    height: 20px;
    accent-color: #194bff;
}

.child-checkbox {
    margin-left: 10%;
}

.grandchild-checkbox {
    margin-top: 1rem;
    padding-left: 20%;
}
</style>