import {
    createApp
} from 'vue/dist/vue.esm-bundler';


import axios from 'axios'

window.axios = axios
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.withCredentials = true
axios.defaults.baseURL = '/api/v1'

import calendario from './components/calendario.vue'

const app = createApp({
    data() {
        return {
            count: 0
        }
    }
})

app.component('calendario', calendario)

app.mount('#app')