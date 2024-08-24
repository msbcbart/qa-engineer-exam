import './bootstrap';
import './ziggy';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import CKEditor from '@ckeditor/ckeditor5-vue';

import { createApp } from 'vue/dist/vue.esm-bundler'

import ProductListComponent from './Components/Product/ListComponent.vue'
import ProductFormComponent from './Components/Product/FormComponent.vue'
import VideosComponent from './Components/Videos.vue'

const app = createApp({})

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#6c757d',
};

app.component('ProductListComponent', ProductListComponent)
app.component('ProductFormComponent', ProductFormComponent)
app.component('VideosComponent', VideosComponent)
app.use(VueSweetalert2, options).use(CKEditor).mount('#app')