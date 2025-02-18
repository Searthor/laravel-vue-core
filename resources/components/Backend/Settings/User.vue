<template>
  <div class="row page-titles mx-0 px-4">
    <div class="col-sm-6 p-md-0">
      <div class="welcome-text">
        <h5>
          <i class="fas fa-layer-group"></i>
          {{ $t("settings") }}
          <i class="fa fa-angle-double-right"></i>
          {{ $t("user") }}
        </h5>
      </div>
    </div>
    <div class="col-sm-6 justify-content-sm-end d-flex">
      <router-link to="dashboard"
        ><i class="fa fa-home"></i> Dashboard</router-link
      >
    </div>
  </div>
  <div class="col-lg-12 mt-4">
    <div class="card">
      <div class="card-header card-light">
        <div class="row w-100">
          <div class="col-md-1">
            <select class="form-control">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="100">100</option>
              <option value="500">500</option>
              <option value="1000">1,000</option>
            </select>
          </div>

          <div class="col-md-2">
            <button class="btn btn-primary btn" @click="openModal">
              {{ $t("add") }}
            </button>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <input
              type="text"
              class="form-control"
              :placeholder="$t('search') + '...'"
              @input="searchData"
            />
          </div>
        </div>
      </div>

      <div class="card-body">
        <div v-if="isLoading" class="text-center">
                    <div class="spinner-border" User="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
        <div class="table-responsive">
          <table class="table table-responsive-sm">
            <thead>
              <tr class="text-center">
                <th scope="col">{{ $t("no") }}</th>
                <th scope="col">{{ $t("firstname") }}</th>
                <th scope="col">{{ $t("lastname") }}</th>
                <th scope="col">{{ $t("phone") }}</th>
                <th scope="col">{{ $t("email") }}</th>
                <th scope="col">{{ $t("role") }}</th>
                <th scope="col">{{ $t("village") }}</th>
                <th scope="col">{{ $t("district") }}</th>
                <th scope="col">{{ $t("province") }}</th>
                <th scope="col">{{ $t("status") }}</th>
                <th scope="col">{{ $t("action") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="text-center"
                v-for="(item, i) in dataList"
                :key="item.id"
              >
                <td>{{ i + 1 }}</td>
                <td>{{ item.firstname }}</td>
                <td>{{ item.lastname }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.role.name }}</td>
                <td>{{ item.village?.name_la ?? ''  }}</td>
                <td>{{ item.district?.name_la ?? '' }}</td>
                <td>{{ item.province?.name_la ?? '' }}</td>
                <td>
                  <div class="form-check form-switch" v-if="item.del == 1">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="flexSwitchCheckChecked{{ item.id }}"
                      checked
                    />
                    ໃຊ້ງານ
                  </div>
                  <div class="form-check form-switch" v-else-if="item.del == 0">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="flexSwitchCheckChecked{{ item.id }}"
                    />ບໍ່ໃຊ້ງານ
                  
                  </div>
                </td>
                <td>
                  <button
                    class="btn btn-success btn-sm"
                    @click="showEdit(item)"
                  >
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button
                    class="btn btn-danger ml-2 btn-sm"
                    @click="openModaldelete(item.id)"
                  >
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
  <div
    v-if="showModal"
    class="modal fade show"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    id="modal-add"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <b>{{ form.id ? $t("edit") : $t("add") }}</b>
          </h5>
          <button type="button " class="btn" @click="closeModal">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>
                    <span class="text-danger">*</span>
                    {{ $t("firstname") }}</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.firstname"
                    :placeholder="$t('firstname')"
                    :class="{ 'is-invalid': errors.firstname }"
                  />
                  <span class="text-danger" v-if="errors.firstname">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("lastname") }}</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.lastname"
                    :placeholder="$t('lastname')"
                    :class="{ 'is-invalid': errors.lastname }"
                  />
                  <span class="text-danger" v-if="errors.lastname">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span> {{ $t("phone") }}</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.phone"
                    :placeholder="$t('phone')"
                    :class="{ 'is-invalid': errors.phone }"
                  />
                  <span class="text-danger" v-if="errors.phone">{{
                    errors.phone
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ $t("email") }}</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.email"
                    :placeholder="$t('email')"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("province") }}</label
                  >
                  <select
                    v-model="form.pro_id"
                    id=""
                    @change="selectDistrict"
                    class="form-control"
                    aria-label="Default select example"
                    :class="{ 'is-invalid': errors.pro_id }"
                  >
                    <option value="">{{ $t("select") }}</option>
                    <option
                      v-for="item in provinceList"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.name_la }}
                    </option>
                  </select>
                  <span class="text-danger" v-if="errors.pro_id">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("district") }}</label
                  >
                  <select
                    v-model="form.dis_id"
                    @change="selectVillage"
                    class="form-control select2"
                    aria-label="Default select example"
                    :class="{ 'is-invalid': errors.dis_id }"
                    ref="select2District"
                  >
                    <option value="">{{ $t("select") }}</option>
                    <option
                      v-for="item in selectdistrictList"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.name_la }}
                    </option>
                  </select>
                  <span class="text-danger" v-if="errors.dis_id">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("village") }}</label
                  >
                  <select
                    ref="select2Village"
                    v-model="form.vill_id"
                    id=""
                    class="form-control select2"
                    aria-label="Default select example"
                    :class="{ 'is-invalid': errors.vill_id }"
                  >
                    <option value="">{{ $t("select") }}</option>
                    <option
                      v-for="item in selectvillageList"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.name_la }}
                    </option>
                  </select>
                  <span class="text-danger" v-if="errors.vill_id">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span> {{ $t("role") }}</label
                  >

                  <select
                    v-model="form.role_id"
                    id=""
                    class="form-select"
                    aria-label="Default select example"
                    :class="{ 'is-invalid': errors.role_id }"
                  >
                    <option value="">{{ $t("select") }}</option>
                    <option
                      v-for="item in rolesList"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span class="text-danger" v-if="errors.role_id">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("password") }}</label
                  >
                  <input
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    :placeholder="$t('password')"
                    :class="{ 'is-invalid': errors.password }"
                  />
                  <span class="text-danger" v-if="errors.password">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    ><span class="text-danger">*</span>
                    {{ $t("confirm_password") }}</label
                  >
                  <input
                    type="password"
                    class="form-control"
                    v-model="form.confirm_password"
                    :placeholder="$t('confirm_password')"
                    :class="{ 'is-invalid': errors.confirm_password }"
                  />
                  <span class="text-danger" v-if="errors.confirm_password">{{
                    $t("please_fill_information_first")
                  }}</span>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">
            {{ $t("close") }}
          </button>
          <button type="button" class="btn btn-primary" @click="submitForm">
            {{ form.id ? $t("edit") : $t("save") }}
          </button>
        </div>
      </div>
    </div>
  </div>
  <div
    v-if="showModaldelete"
    class="modal fade show"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
  >
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header justify-between bg-danger">
          <h5 class="modal-title text-white">ລົບ</h5>
          <button
            type="button"
            class="btn btn-light"
            @click="closeModaldDetele()"
          >
            &times;
          </button>
        </div>
        <div class="modal-body">
          <h1 class="text-center text-xl font-bold">Do you want to delete?</h1>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="closeModaldDetele()"
          >
            ປິດ
          </button>
          <button type="button" class="btn btn-danger" @click="deleteData()">
            ລົບ
          </button>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import axios from "axios";
import { onMounted, onUpdated, ref, computed, watch, nextTick } from "vue";
import {
  fetchPermissions,
  checkPermission,
} from "../../../js/permissionStore.js";
import debounce from "lodash/debounce";
import jquery from "jquery";
window.jQuery = jquery;
window.$ = jquery;
import("select2").then((m) => m.default());

const isLoading = ref(true);
const dataList = ref([]);
const originalDataList = ref([]);
const searchQuery = ref("");
const showModal = ref(false);
const showModaldelete = ref(false);
const errors = ref({});
var deleteID = "";
const rolesList = ref([]);
const provinceList = ref([]);
const districtList = ref([]);
const villageList = ref([]);
const selectdistrictList = ref([]);
const selectvillageList = ref([]);
const select2Village = ref(null);
const select2District = ref(null);

const resetform = () => {
  form.value.id = "";
  form.value.firstname = "";
  form.value.lastname = "";
  form.value.phone = "";
  form.value.email = "";
  form.value.password = "";
  form.value.confirm_password = "";
  form.value.role_id = "";
  form.value.vill_id = "";
  form.value.dis_id = "";
  form.value.pro_id = "";
};
const openModal = () => {
  resetform();
  showModal.value = true;
  initSelect2();
};
const form = ref({
  id: "",
  firstname: "",
  lastname: "",
  phone: "",
  email: "",
  password: "",
  confirm_password: "",
  role_id: "",
  vill_id: "",
  dis_id: "",
  pro_id: "",
});
const closeModal = () => {
  showModal.value = false;
};
const validateForm = () => {
  errors.value = {};
  if (!form.value.firstname) errors.value.firstname = "error";
  if (!form.value.lastname) errors.value.lastname = "error";
  if (!form.value.phone || !isValidPhone(form.value.phone))
    errors.value.phone = "ເບີໂທຕ້ອງເປັນຕົວເລກ";
  if (!form.value.pro_id) errors.value.pro_id = "error";
  if (!form.value.dis_id) errors.value.dis_id = "error";
  if (!form.value.vill_id) errors.value.vill_id = "error";
  if (!form.value.role_id) errors.value.role_id = "error";
  if (!form.value.password && !form.value.id) errors.value.password = "error";
  if (!form.value.confirm_password && !form.value.id)
    errors.value.confirm_password = "error";
  return Object.keys(errors.value).length === 0;
};
const isValidPhone = (phone) => {
  const phoneRegex = /^[0-9]{10}$/;
  return phoneRegex.test(phone);
};
const getRoles = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/roles", { headers });
    rolesList.value = response.data.roles;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
// search data
const filteredData = computed(() => {
  const s = searchQuery.value.toLowerCase().trim();
  if (!s) return originalDataList.value;
  return originalDataList.value.filter(
    (item) =>
      item.firstname.toLowerCase().includes(s) ||
      item.lastname.toLowerCase().includes(s) ||
      item.phone.includes(s)
  );
});
watch(filteredData, (newData) => {
  dataList.value = newData;
});
const searchData = debounce((event) => {
  searchQuery.value = event.target.value;
}, 300);
//end
//address
const getVillage = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/villages", { headers });
    villageList.value = response.data.villages;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
const getDistrict = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/districts", { headers });
    districtList.value = response.data.districts;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
const getProvince = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/provinces", { headers });
    provinceList.value = response.data.provinces;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
const selectDistrict = (event) => {
  const id = event.target.value;
  districtListById(id);
};
const districtListById = (id) => {
  if (districtList.value.length > 0) {
    selectdistrictList.value = districtList.value.filter(
      (item) => String(item.province_id) === String(id)
    );
  }
};
const selectVillage = (event) => {
  const id = event.target.value;
  villageListById(id);
};
const villageListById = (id) => {
  if (villageList.value.length > 0) {
    selectvillageList.value = villageList.value.filter(
      (item) => String(item.district_id) === String(id)
    );
  }
};
//end
const getData = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/users", { headers });
    dataList.value = response.data.users;
    originalDataList.value = response.data.users;
    isLoading.value = false;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
onMounted(async () => {
  fetchPermissions().then(() => {
    if (checkPermission("access_user") == false) {
      window.location.href = "/403_authorized";
      return;
    }
  });
  await getData();
  await getRoles();
  await getProvince();
  await getDistrict();
  await getVillage();
  initSelect2();
});
const initSelect2 = () => {
  nextTick(() => {
    $(select2District.value)
      .select2({
        width: "100%",
        dropdownParent: $("#modal-add"),
      })
      .on("change", function () {
        form.value.dis_id = $(this).val();
        villageListById(form.value.dis_id);
      });
    $(select2Village.value)
      .select2({
        width: "100%",
        dropdownParent: $("#modal-add"),
      })
      .on("change", function () {
        form.value.vill_id = $(this).val();
      });
  });
};

const submitForm = async () => {
  if (!validateForm()) {
    initSelect2();
    return;
  }
  if (
    !form.value.id &&
    String(form.value.password) != String(form.value.confirm_password)
  ) {
    toast.fire({ icon: "error", title: "ລະຫັດຢືນຢັນບໍ່ຖືກຕ້ອງ!" });
    return;
  }
  const formData = new FormData();
  formData.append("firstname", form.value.firstname);
  formData.append("lastname", form.value.lastname);
  formData.append("phone", form.value.phone);
  formData.append("email", form.value.email);
  formData.append("pro_id", form.value.pro_id);
  formData.append("dis_id", form.value.dis_id);
  formData.append("vill_id", form.value.vill_id);
  formData.append("role_id", form.value.role_id);
  formData.append("password", form.value.password);
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
      Accept: "application/json", // 👈 Important to prevent CSRF check
    };
    let response;
    if (form.value.id) {
      response = await axios.post(
        `/api/update_users/${form.value.id}`,
        formData,
        { headers }
      );
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    } else {
      response = await axios.post("/api/create_users", formData, { headers });
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    }
    resetform();
    closeModal();
    getData();
  } catch (error) {
    console.error("Error:", error.response?.data || error.message);
    toast.fire({ icon: "error", title: "ມີຂໍ້ຜິດພາດ, ກະລຸນາລອງໃໝ່!" });
  }
};
const showEdit = (item) => {
  form.value.firstname = item.firstname ?? "";
  form.value.lastname = item.lastname ?? "";
  form.value.phone = item.phone ?? "";
  form.value.email = item.email ?? "";
  form.value.pro_id = item.pro_id ?? "";
  form.value.dis_id = item.dis_id ?? "";
  form.value.vill_id = item.vill_id ?? "";
  form.value.role_id = item.role_id ?? "";
  form.value.id = item.id ?? 0;
  districtListById(item.pro_id);
  villageListById(item.dis_id);
  showModal.value = true;
  initSelect2();
};
const deleteData = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
      Accept: "application/json", // 👈 Important to prevent CSRF check
    };
    const response = await axios.delete(`/api/users/${deleteID}`, { headers });
    toast.fire({ icon: "success", title: response.data.message });
    closeModaldDetele();
    getData();
  } catch (error) {
    console.error("Error deleting User:", error);
  }
};

const openModaldelete = (id) => {
  deleteID = id;
  showModaldelete.value = true;
};

const closeModaldDetele = () => {
  deleteID = null;
  showModaldelete.value = false;
};
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