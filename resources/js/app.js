import "./bootstrap";
import { createApp } from "vue";
import App from "../components/App.vue";
import Swal from 'sweetalert2';
import axios from 'axios';
import { createI18n } from 'vue-i18n';
import { fetchPermissions, checkPermission } from "./permissionStore.js";
import laLanguage from '../lang/la.json';
import enLanguage from '../lang/en.json';
import cnLanguage from '../lang/cn.json';
import 'quill/dist/quill.snow.css';

window.Swal = Swal
const toast = Swal.mixin({
    toast:true,
    position:'top-right',
    showConfirmButton:false,
    timer:3000,
    timerProgressBar:true
})
window.toast = toast
import router from "./router";
const i18n = createI18n({
    locale: 'la',  
    fallbackLocale: 'en',
    messages: {
        en: enLanguage,
        la: laLanguage,
        cn: cnLanguage
    }
});
const app = createApp(App);
//check access functions
app.config.globalProperties.$checkPermission = checkPermission;
fetchPermissions();
//end
// Change language dynamically
app.config.globalProperties.$changeLanguage = (event) => {
    const lang = event.target.value;
    i18n.global.locale = lang;
};
// show image
app.config.globalProperties.$getImageUrl = (imagePath) => {
    if (!imagePath) return 'image/logo.png';
    return `${window.location.origin}/${imagePath}`;
  };
//end
app.use(i18n).use(router).mount("#app");
