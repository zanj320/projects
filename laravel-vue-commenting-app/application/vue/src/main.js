import { createApp } from 'vue'
import { createPinia } from "pinia";
import './style.css'
import App from './App.vue'
import router from './router'
import axios from 'axios'

import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'bootstrap/dist/css/bootstrap.css';

const pinia = createPinia();

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

createApp(App)
    .use(router)
    .use(pinia)
    .mount('#app')