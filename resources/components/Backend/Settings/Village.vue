<template>
  <div class="row page-titles mx-0 px-4">
    <div class="col-sm-6 p-md-0">
      <div class="welcome-text">
        <h5>
          <i class="fas fa-layer-group"></i>
          {{ $t("settings") }}
          <i class="fa fa-angle-double-right"></i>
          {{ $t("village") }}
        </h5>
      </div>
    </div>
    <div class="col-sm-6 justify-content-sm-end d-flex">
      <router-link to="dashboard"
        ><i class="fa fa-home"></i> Dashboard</router-link
      >
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 mt-4">
      <div class="card">
        <div class="card-header">
          <label for="">{{ $t("add") }} / {{ $t("edit") }}</label>
        </div>
        <div class="card-body">
          <form @submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("district") }}</label
                  >
                  <select
                    v-model="form.district_id"
                    class="form-control select2"
                    aria-label="Default select example"
                    :class="{ 'is-invalid': errors.district_id }"
                    ref="select2District"
                  >
                    <option value="">{{ $t("select") }}</option>
                    <option
                      v-for="item in districtList"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.name_la }}
                    </option>
                  </select>
                  <span class="text-danger" v-if="errors.district_id">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for=""
                    ><span class="text-danger">*</span
                    >{{ $t("name") }} Lao</label
                  >
                  <input
                    v-model="form.name_la"
                    type="text"
                    class="form-control"
                    placeholder=""
                    :class="{ 'is-invalid': errors.name_la }"
                  />
                  <span class="text-danger" v-if="errors.name_la">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for=""
                    ><span class="text-danger">*</span
                    >{{ $t("name") }} English</label
                  >
                  <input
                    v-model="form.name_en"
                    type="text"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for=""
                    ><span class="text-danger">*</span
                    >{{ $t("name") }} Chinese</label
                  >
                  <input
                    v-model="form.name_cn"
                    type="text"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between">
            <button
              @click="resetform"
              type="button"
              class="btn btn-sm btn-primary"
            >
              <i class="fa fa-refresh" aria-hidden="true"></i> Reset
            </button>
            <button
              @click="submitForm"
              type="button"
              class="btn btn-sm btn-success"
            >
              <i class="fa fa-download"></i> {{ $t("save") }}
            </button>
          </div>
          <!--[if ENDBLOCK]><![endif]-->
        </div>
      </div>
    </div>
    <div class="col-md-8 mt-4">
      <div class="card">
        <div class="card-header card-light">
          <div class="row w-100">
            <div class="col-md-3">
              <input
                v-model="searchQuery"
                type="text"
                class="form-control"
                :placeholder="$t('search') + '...'"
              />
            </div>
            <div class="col-md-2">
              <select v-model="perPage" class="form-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="1000">1,000</option>
              </select>
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" @click="openModal">
                {{ $t("add") }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div v-if="isLoading" class="text-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>

          <div class="table-responsive" v-if="!isLoading">
            <table class="table table-responsive-sm">
              <thead>
                <tr class="text-center">
                  <th scope="col">{{ $t("no") }}</th>
                  <th scope="col">{{ $t("village") }}</th>
                  <th scope="col">{{ $t("district") }}</th>
                  <th scope="col">{{ $t("action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="text-center"
                  v-for="(item, index) in paginatedData"
                  :key="item.id"
                >
                  <td>{{ (currentPage - 1) * perPage + index + 1 }}</td>
                  <td>{{ item.name_la }}</td>
                  <td>{{ item.district?.name_la ?? '' }}</td>
                  <td>
                    <button
                      class="btn btn-success btn-sm"
                      @click="showEdit(item)"
                    >
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav v-if="!isLoading">
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link" @click="changePage(currentPage - 1)">
                  «
                </button>
              </li>

              <li class="page-item" :class="{ active: currentPage === 1 }">
                <button class="page-link" @click="changePage(1)">1</button>
              </li>

              <li v-if="startPage > 2" class="page-item disabled">
                <span class="page-link">...</span>
              </li>

              <li
                v-for="page in displayedPages"
                :key="page"
                class="page-item"
                :class="{ active: page === currentPage }"
              >
                <button class="page-link" @click="changePage(page)">
                  {{ page }}
                </button>
              </li>

              <li v-if="endPage < totalPages - 1" class="page-item disabled">
                <span class="page-link">...</span>
              </li>

              <li
                v-if="totalPages > 1"
                class="page-item"
                :class="{ active: currentPage === totalPages }"
              >
                <button class="page-link" @click="changePage(totalPages)">
                  {{ totalPages }}
                </button>
              </li>

              <li
                class="page-item"
                :class="{ disabled: currentPage === totalPages }"
              >
                <button class="page-link" @click="changePage(currentPage + 1)">
                  »
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script setup>
import { ref, computed, onMounted,nextTick } from "vue";
import axios from "axios";
import jquery from "jquery";
window.jQuery = jquery;
window.$ = jquery;
import("select2").then((m) => m.default());

const dataList = ref([]);
const isLoading = ref(true);
const searchQuery = ref("");
const perPage = ref(10);
const currentPage = ref(1);
const errors = ref({});
const select2District =  ref(null);
const districtList = ref([]);
const form = ref({
  id: "",
  name_la: "",
  name_en: "",
  name_cn: "",
  district_id: ""
});

// Fetch data from API
const getData = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = { Authorization: `Bearer ${token}` };
    const response = await axios.get("/api/villages", { headers });
    dataList.value = response.data.villages;
    isLoading.value = false;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};
const getDistrict = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = { Authorization: `Bearer ${token}` };
    const response = await axios.get("/api/districts", { headers });
    districtList.value = response.data.districts;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

// Computed property: Filtered data based on search query
const filteredData = computed(() => {
  if (!searchQuery.value) return dataList.value;
  const query = searchQuery.value.toLowerCase();
  
  return dataList.value.filter((item) =>
    item.name_la.toLowerCase().includes(query) ||
    item.district?.name_la?.toLowerCase().includes(query) // Ensure safe optional chaining
  );
});
// Computed property: Total Pages
const totalPages = computed(() =>
  Math.ceil(filteredData.value.length / perPage.value)
);

// Computed property: Paginated Data
const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  return filteredData.value.slice(start, start + perPage.value);
});

// Computed property: Determine visible pages
const displayedPages = computed(() => {
  const pages = [];
  let startPage = Math.max(2, currentPage.value - 2);
  let endPage = Math.min(totalPages.value - 1, currentPage.value + 2);

  if (currentPage.value <= 3) {
    startPage = 2;
    endPage = Math.min(5, totalPages.value - 1);
  }
  if (currentPage.value >= totalPages.value - 2) {
    startPage = Math.max(totalPages.value - 4, 2);
    endPage = totalPages.value - 1;
  }
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i);
  }
  return pages;
});

// Change Page Function
const changePage = (page) => {
  if (page > 0 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

// Fetch data on component mount
onMounted(async () => {
    await getDistrict();
    initSelect2();
    await getData();
});
const initSelect2 = () => {
  nextTick(() => {
    $(select2District.value)
      .select2({
        width: "100%",
      })
      .on("change", function () {
        form.value.district_id = $(this).val();
      });
  });
};
const validateForm = () => {
  errors.value = {};
  if (!form.value.name_la) errors.value.name_la = "Name is required.";
  if (!form.value.district_id) errors.value.district_id = "District is required.";
  return Object.keys(errors.value).length === 0;
};
const resetform = () => {
  form.value.name_la = "";
  form.value.name_en = "";
  form.value.name_cn = "";
  form.value.id = "";
  form.value.district_id = "";
  initSelect2();
};
const showEdit = (item) => {
  form.value.name_la = item.name_la;
  form.value.name_en = item.name_en;
  form.value.name_cn = item.name_cn;
  form.value.id = item.id;
  form.value.district_id = item.district_id;
  initSelect2();
};
//ບັນທຶຶຶກ ຫຼືື ແກ້ໄຂ
const submitForm = async () => {
  if (!validateForm()) return;
  const formData = new FormData();
  formData.append("name_la", form.value.name_la);
  formData.append("name_en", form.value.name_en);
  formData.append("name_cn", form.value.name_cn);
  formData.append("district_id", form.value.district_id);
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
      Accept: "application/json",
    };
    let response;
    if (form.value.id) {
      response = await axios.post(
        `/api/update_villages/${form.value.id}`,
        formData,
        { headers }
      );
     // Find the existing item and update it
      const index = dataList.value.findIndex((item) => item.id === form.value.id);
      if (index !== -1) {
        dataList.value[index] = response.data.village; // Update specific village
      }
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    } else {
      response = await axios.post("/api/create_villages", formData, {
        headers,
      });
      dataList.value.unshift(response.data.village);
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    }
    resetform();
  } catch (error) {
    console.error("Error:", error.response?.data || error.message);
    toast.fire({ icon: "error", title: "ມີຂໍ້ຜິດພາດ, ກະລຸນາລອງໃໝ່!" });
  }
};
//end
</script>
  
  <style scoped>
.table-responsive {
  margin-top: 20px;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.page-item {
  margin: 0 3px;
}

.page-item.disabled .page-link {
  pointer-events: none;
  opacity: 0.5;
}

.page-item.active .page-link {
  background-color: #007bff;
  color: white;
}
</style>
  