window.axios = require('axios')

axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('id_token')}`
axios.defaults.withCredentials = true;