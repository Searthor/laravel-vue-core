<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";

const products = ref([]);
const links = ref([]);
const showModal = ref(false);
const showModaldelete = ref(false);
const isLoading = ref(false);
var deleteID = null;

const form = ref({
    name: "",
    description: "",
    image: "",
    quantity: "",
    price: "",
});
const errors = ref({});
const searchQuery = ref(""); // Reactive property for search query

onMounted(async () => {
    await getproducts();
});

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onloadend = () => {
            form.value.image = reader.result;
        };
        reader.readAsDataURL(file);
    }

};

const getproducts = async () => {
    isLoading.value = true;
    try {
        let response = await axios.get('/api/products');
        products.value = response.data.products.data;
        links.value = response.data.products.links;
    } catch (error) {
        console.error('Error fetching products:', error);
    } finally {
        isLoading.value = false;
    }
};

const ourImage = (img) => {
    return "/upload/" + img;
};

const changePage = async (link) => {
    if (!link.url || link.active) return;
    try {
        let response = await axios.get(link.url);
        products.value = response.data.products.data;
        links.value = response.data.products.links;
    } catch (error) {
        console.error('Error changing page:', error);
    }
};

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.value = { name: '', type: '', quantity: 0, image: null };
    errors.value = {};
};

const validateForm = () => {
    errors.value = {};
    if (!form.value.name) errors.value.name = 'Product name is required.';
    if (form.value.quantity <= 0) errors.value.quantity = 'Quantity must be greater than 0.';
    return Object.keys(errors.value).length === 0;
};

const submitForm = async () => {
    if (!validateForm()) return;

    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('quantity', form.value.quantity);
    formData.append('description', form.value.description);
    formData.append('price', form.value.price);

    // If the image is selected, send the base64 string
    if (form.value.image) {
        formData.append('image', form.value.image);
    }

    try {
        const response = await axios.post('/api/products', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        toast.fire({ icon: "success", title: "Product Added Successfully" });
        closeModal();
        await getproducts();
    } catch (error) {
        console.error('Error submitting form:', error);
    }
};


const openModaldelete = (id) => {
    deleteID = id
    showModaldelete.value = true

};

const closeModaldDetele = () => {
    deleteID = null
    showModaldelete.value = false
}

const updateProduct = async (id) => {
    const selectedProduct = products.value.find((product) => product.id === id);
    if (selectedProduct) {
        form.value = {
            name: selectedProduct.name,
            id: id,
            price: selectedProduct.price,
            type: selectedProduct.type,
            quantity: selectedProduct.quantity,
        };
        showModal.value = true;
    }
};

// Computed property to filter products based on search query
const filteredProducts = computed(() => {

    return products.value.filter(product =>
        product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        getProductTypeName(product.type).toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>

<template>
    <div class="row page-titles mx-0 px-4">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <p>Product</p>
            </div>
        </div>
        <div class="col-sm-6  justify-content-sm-end  d-flex">
            <a>Dashboard</a>
        </div>
    </div>

    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-header p-3">
                <div class="row w-100">
                    <div class="col-md-3">
                        <input class="form-control" v-model="searchQuery" placeholder="Search...">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn" @click="openModal">Add Product</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div v-if="isLoading" class="text-center">
                    <!-- <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div> -->
                </div>
                <div v-else class="table-responsive">
                    <table class="table table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Product</th>
                                <th scope="col">Inventory</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in filteredProducts" :key="product.id">
                                <td><img :src="ourImage(product.image)" style="height: 40px;" alt=""></td>
                                <td>{{ product.name }}</td>

                                <td>{{ product.quantity }}</td>
                                <td>
                                    <button class="btn btn-success" @click="updateProduct(product.id)">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger" @click="openModaldelete(product.id)">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <a href="#" class="btn" v-for="(link, index) in links" :key="index" v-html="link.label"
                        :class="{ active: link.active, disabled: !link.url }" @click="changePage(link)"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-between bg-primary">
                    <h5 class="modal-title text-white">{{ form.id ? 'Edit' : 'Add' }}</h5>
                    <button type="button" class="close text-white" @click="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" v-model="form.name"
                                placeholder="Enter product name">
                            <span class="text-danger" v-if="errors.name">{{ errors.name }}</span>
                        </div>

                        <div class="form-group">
                            <label>description</label>
                            <input type="text" class="form-control" v-model="form.description" placeholder="Enter type">
                            <span class="text-danger" v-if="errors.description">{{ errors.description }}</span>
                        </div>
                        <div class="form-group">
                            <label>Inventory</label>
                            <input type="number" class="form-control" v-model="form.quantity"
                                placeholder="Enter quantity">
                            <span class="text-danger" v-if="errors.quantity">{{ errors.quantity }}</span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" v-model="form.price" placeholder="Enter Price">
                            <span class="text-danger" v-if="errors.quantity">{{ errors.price }}</span>
                        </div>
                        <!-- <div class="form-group">
                            <label>Upload Image</label>
                            <input type="file" class="form-control" @change="handleFileChange">
                        </div> -->
                    </form>
                </div>
                <div class="modal-footer flex justify-between px-10">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                    <button type="button" :class="['btn', form.id ? 'btn-warning' : 'btn-primary']"
                        @click="submitForm">{{ form.id ? 'Edit' : 'Add' }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal delete -->
    <div v-if="showModaldelete" class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-between bg-danger">
                    <h5 class="modal-title text-white">Delete</h5>
                    <button type="button" class="close text-white" @click="closeModaldDetele()">&times;</button>
                </div>
                <div class="modal-body">
                    <h1 class="text-center text-xl font-bold">Do you want to delete?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModaldDetele()">Close</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>
.pagination {
    display: flex;
    justify-content: end;
    margin-top: 20px;
}

.pagination .btn {
    margin: 0 5px;
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.pagination .btn.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination .btn.disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>