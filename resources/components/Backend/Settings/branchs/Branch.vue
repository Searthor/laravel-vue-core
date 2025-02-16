<template> 
  <div class="row page-titles mx-0 px-4">
    <div class="col-sm-6 p-md-0">
      <div class="welcome-text">
        <h5>
          <i class="fas fa-layer-group"></i>
          {{ $t("settings") }}
          <i class="fa fa-angle-double-right"></i>
          {{ $t("branch") }}
        </h5>
      </div>
    </div>
    <div class="col-sm-6 justify-content-sm-end d-flex">
      <router-link  to="dashboard"><i class="fa fa-home"></i> Dashboard</router-link>
    </div>
  </div>

  <div class="col-lg-12 mt-4">
    <div class="card">
      <!-- <div class="card-header card-light">
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
                        <button class="btn btn-primary btn" @click="openModal">{{ $t('add') }}</button>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" :placeholder="$t('search') + '...'" />
                    </div>
                </div>
            </div> -->

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
                <th scope="col">{{ $t("no") }}</th>
                <th scope="col">{{ $t("logo") }}</th>
                <th scope="col">{{ $t("name") }}</th>
                <th scope="col">{{ $t("phone") }}</th>
                <th scope="col">{{ $t("email") }}</th>
                <th scope="col">{{ $t("address") }}</th>
                <th scope="col">{{ $t("action") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center" v-for="item in dataList" :key="item.id">
                <td>{{ item.id }}</td>
                <td>
                  <img
                    :src="$getImageUrl(item.logo)"
                    alt="Branch Logo"
                    style="width: 50px"
                  />
                </td>
                <td>{{ item.name_la }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.address_la }}</td>
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

        <!-- <div class="pagination">
                    <a href="#" class="btn" v-for="(link, index) in links" :key="index" v-html="link.label"
                        :class="{ active: link.active, disabled: !link.url }" @click="changePage(link)"></a>
                </div> -->
      </div>
    </div>
  </div>
  <!-- ແກ້ໄຂຂໍ້ມູນ -->
  <div v-if="showModal" class="modal fade show d-block">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">
            <b>{{ form.id ? "ແກ້ໄຂສິດ" : "ເພີ່ມສິດ" }}</b>
          </h5>
          <button type="button" class="btn btn-danger" @click="closeModal">
            <i class="fa fa-close"></i>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <div class="row">
              <!-- Lao Name -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("name") }} (Lao)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name_la"
                    required
                  />
                </div>
              </div>

              <!-- English Name -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("name") }} (English)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name_en"
                    required
                  />
                </div>
              </div>

              <!-- Chinese Name -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("name") }} (Chinese)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name_cn"
                  />
                </div>
              </div>

              <!-- Phone -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ $t("phone") }}</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.phone"
                    required
                  />
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ $t("email") }}</label>
                  <input
                    type="email"
                    class="form-control"
                    v-model="form.email"
                  />
                </div>
              </div>

              <!-- Address Lao -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("address") }} (Lao)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.address_la"
                    required
                  />
                </div>
              </div>

              <!-- Address English -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("address") }} (English)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.address_en"
                  />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("address") }} (Chinese)</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.address_cn"
                  />
                </div>
              </div>
              <!-- Social Media Links -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>WhatsApp</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.whatapps"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Facebook</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.facebook"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>YouTube</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.youtube"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Google Map</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.google_map"
                  />
                </div>
              </div>

              <!-- App Store Links -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Play Store</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.play_store"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>App Store</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.app_store"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>App Gallery</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.app_gallery"
                  />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ $t("bill_header") }}</label>
                  <div ref="headerEditor" class="quill-editor"></div>
                  <textarea
                    type="text"
                    class="form-control"
                    v-model="form.bill_header"
                    hidden
                  >
                  </textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ $t("bill_footer") }}</label>
                  <div ref="footerEditor" class="quill-editor"></div>
                  <textarea
                    type="text"
                    class="form-control"
                    v-model="form.bill_footer"
                    hidden
                  >
                  </textarea>
                </div>
              </div>

              <!-- Logo Upload -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ $t("logo") }}</label>
                  <input
                    type="file"
                    class="form-control"
                    @change="handleFileUpload"
                    accept=".png,.jpg.jpeg"
                  />
                </div>
              </div>
            </div>
            <div class="row mt-2" v-if="imageUrl || form.logo != ''">
              <div class="col-md-3 text-center">
                <div class="card">
                  <div class="card-body">
                    <!-- Show Image from Local File Input Preview -->
                    <img
                      v-if="imageUrl"
                      :src="imageUrl"
                      alt="Selected Image"
                      style="max-width: 100%; height: auto"
                    />

                    <!-- Show Image from the Server (Uploaded Logo) -->
                    <img
                      v-else-if="form.logo != ''"
                      :src="$getImageUrl(form.logo)"
                      alt="Selected Image"
                      style="max-width: 100%; height: auto"
                    />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Modal Footer -->
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
  <!-- end -->
</template>


<script setup>
import axios from "axios";
import { onMounted, ref, nextTick } from "vue";
import { fetchPermissions,checkPermission } from "../../../../js/permissionStore";
import Quill from "quill";
const showModal = ref(false);
const errors = ref({});
const dataList = ref([]);
const imageUrl = ref(null);
const headerEditor = ref(null);
const footerEditor = ref(null);
const quillInstances = {};
const form = ref({
  id: "",
  name_la: "",
  name_en: "",
  name_cn: "",
  phone: "",
  email: "",
  address_la: "",
  address_en: "",
  address_cn: "",
  whatapps: "",
  facebook: "",
  youtube: "",
  google_map: "",
  play_store: "",
  app_store: "",
  app_gallery: "",
  director_sign: "",
  chechker_sign: "",
  customer_sign: "",
  staff_sign: "",
  bill_header: "",
  bill_footer: "",
  logo: "",
});
const closeModal = () => {
  showModal.value = false;
};
const validateForm = () => {
  errors.value = {};
  if (!form.value.name_la)
    errors.value.name_la = $t("please_fill_information_first");
  return Object.keys(errors.value).length === 0;
};
const getData = async () => {
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
    };
    const response = await axios.get("/api/branches", { headers });
    dataList.value = response.data.branches;
  } catch (error) {
    console.error("Error fetching function model:", error);
  }
};
onMounted(async () => {
  fetchPermissions().then(() => {
    if (checkPermission("access_branch") == false) {
      window.location.href = "/403_authorized";
      return;
    }
  })
  await getData();
  showTextEditor();
});
const showTextEditor = () => {
  nextTick(() => {
    if (headerEditor.value) {
      quillInstances.header = new Quill(headerEditor.value, {
        theme: "snow",
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            [{ font: [] }],
            [{ size: [] }],
            [{ color: [] }, { background: [] }],
            [{ script: "sub" }, { script: "super" }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ align: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ indent: "-1" }, { indent: "+1" }],
            ["blockquote", "code-block"],
            ["link", "image", "video"],
            ["clean"],
          ],
        },
      });

      quillInstances.header.root.innerHTML = form.value.bill_header || "";
      quillInstances.header.on("text-change", () => {
        form.value.bill_header = quillInstances.header.root.innerHTML;
      });
    }

    if (footerEditor.value) {
      quillInstances.footer = new Quill(footerEditor.value, {
        theme: "snow",
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            [{ font: [] }],
            [{ size: [] }],
            [{ color: [] }, { background: [] }],
            [{ script: "sub" }, { script: "super" }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ align: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ indent: "-1" }, { indent: "+1" }],
            ["blockquote", "code-block"],
            ["link", "image", "video"],
            ["clean"],
          ],
        },
      });

      quillInstances.footer.root.innerHTML = form.value.bill_footer || "";
      quillInstances.footer.on("text-change", () => {
        form.value.bill_footer = quillInstances.footer.root.innerHTML;
      });
    }
  });
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    imageUrl.value = URL.createObjectURL(file);
    form.value.logo = file;
  }
};

const showEdit = (item) => {
  form.value.id = item.id;
  form.value.name_la = item.name_la;
  form.value.name_en = item.name_en;
  form.value.name_cn = item.name_cn;
  form.value.phone = item.phone;
  form.value.email = item.email;
  form.value.address_la = item.address_la ?? "";
  form.value.address_en = item.address_en ?? "";
  form.value.address_cn = item.address_cn ?? "";
  form.value.whatapps = item.whatapps ?? "";
  form.value.facebook = item.facebook ?? "";
  form.value.youtube = item.youtube ?? "";
  form.value.google_map = item.google_map ?? "";
  form.value.play_store = item.play_store ?? "";
  form.value.app_store = item.app_store ?? "";
  form.value.app_gallery = item.app_gallery ?? "";
  form.value.director_sign = item.director_sign ?? "";
  form.value.chechker_sign = item.chechker_sign ?? "";
  form.value.customer_sign = item.customer_sign ?? "";
  form.value.staff_sign = item.staff_sign ?? "";
  form.value.bill_header = item.bill_header ?? "";
  form.value.bill_footer = item.bill_footer ?? "";
  form.value.logo = item.logo ?? "";
  showModal.value = true; // Open the modal
  nextTick(() => {
    showTextEditor();
  });
};

const submitForm = async () => {
  if (!validateForm()) return;
  const formData = new FormData();
  formData.append("name_la", form.value.name_la);
  formData.append("name_en", form.value.name_en);
  formData.append("name_cn", form.value.name_cn);
  formData.append("phone", form.value.phone);
  formData.append("email", form.value.email);
  formData.append("address_la", form.value.address_la);
  formData.append("address_en", form.value.address_en);
  formData.append("address_cn", form.value.address_cn);
  formData.append("whatapps", form.value.whatapps);
  formData.append("facebook", form.value.facebook);
  formData.append("youtube", form.value.youtube);
  formData.append("google_map", form.value.google_map);
  formData.append("play_store", form.value.play_store);
  formData.append("app_store", form.value.app_store);
  formData.append("app_gallery", form.value.app_gallery);
  formData.append("director_sign", form.value.director_sign);
  formData.append("chechker_sign", form.value.chechker_sign);
  formData.append("customer_sign", form.value.customer_sign);
  formData.append("staff_sign", form.value.staff_sign);
  formData.append("bill_header", form.value.bill_header);
  formData.append("bill_footer", form.value.bill_footer);
  // Handle File Upload (if logo is selected)
  if (form.value.logo) {
    formData.append("logo", form.value.logo);
  }
  try {
    const token = localStorage.getItem("auth_token");
    const headers = {
      Authorization: `Bearer ${token}`,
      Accept: "application/json",
    };
    let response;
    if (form.value.id) {
      response = await axios.post(
        `/api/update_branches/${form.value.id}`,
        formData,
        {
          headers,
        }
      );
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    } else {
      response = await axios.post("/api/branches", formData, { headers });
      toast.fire({ icon: "success", title: "ສໍາເລັດແລ້ວ" });
    }
    closeModal();
    getData();
  } catch (error) {
    console.error("Error:", error.response?.data || error.message);
    toast.fire({
      icon: "error",
      title: "An error occurred. Please try again!",
    });
  }
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