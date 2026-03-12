import axios from 'axios'
import store from '../store/storage.js'
import router from '../router/router.js'

export default function setup() {
    axios.interceptors.request.use(function(config) {
        store.dispatch('isLoading', true);
        store.dispatch('setErrors', {
            errors: {}
        })
        return config;
    }, function(err) {
        return Promise.reject(err);
    });

    axios.interceptors.response.use(function(config) {
        store.dispatch('isLoading', false);
        return config;
    }, function(err) {
        if (err.response.status == 422) {
            store.dispatch('setErrors', err.response.data)
        }
        if (err.response.status == 401) {
            localStorage.removeItem('id_token')
            localStorage.removeItem('user_name')
            localStorage.removeItem('user_email')
            localStorage.removeItem('role')
            localStorage.removeItem('user_id')
            store.dispatch('setAuth', false)
            store.dispatch('setUser', {
                name: '...',
            })
            router.push({
                path: '/login'
            }).catch(() => {})
        }
        store.dispatch('isLoading', false);
        return Promise.reject(err);
    });
}