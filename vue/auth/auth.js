import router from '../router/router.js'
import store from '../store/storage.js'

export default {
    user: {
        authenticated: false,
    },

    signin: function(user) {
        axios.post('login', user).then(response => {
            this.setLocalStorage(response.data)
            this.dispatchUser(response.data.user)
            this.user.authenticated = true
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token
            //this.handleRedirectByRole(response.data.user.role)
            router.push('/')
        }).catch(error => {
            error.response.status == 401 ? store.dispatch('setLoginErrors', error.response.data) : store.dispatch('setLoginErrors', {
                message: null
            })
        })
    },

    handleRedirectByRole(role) {
        if (role == 'admin' || role == 'secretaria') {
            router.push('/')
        }
        if (role == 'gestion') {
            router.push('/')
        }
        if (role == 'atencion') {
            router.push('/proyectos')
        }
        if (role == 'docente') {
            router.push('/docente-proyectos')
        }
        if (role == 'alumno') {
            router.push('/mis-proyectos')
        }
        if (role == 'facturacion') {
            router.push('/facturas-f')
        }
    },

    dispatchUser: function(data) {
        store.dispatch('setAuth', true)
        store.dispatch('setUser', data)
    },

    setLocalStorage: function(data) {
        localStorage.setItem('id_token', data.access_token)
        localStorage.setItem('user_name', data.user.name)
        localStorage.setItem('user_email', data.user.email)
        localStorage.setItem('role', data.user.role)
        localStorage.setItem('user_id', data.user.id)
    },

    logout: function() {
        localStorage.removeItem('id_token')
        localStorage.removeItem('user_name')
        localStorage.removeItem('role')
        localStorage.removeItem('user_email')
        localStorage.removeItem('user_id')
        store.dispatch('setAuth', false)
        store.dispatch('setUser', this.setDefault())
        router.push('/login')
    },

    setDefault: function() {
        return {
            name: '...',
        }
    },

    authenticated: function() {
        return this.check()
    },

    check: function() {
        return (localStorage.getItem('id_token') !== null) ? true : false
    }
}