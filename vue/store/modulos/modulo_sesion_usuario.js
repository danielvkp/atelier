const modulo_sesion_usuario = {
    strict: false,

    state: {
        is_loading: false,
        auth: false,
        user: {
            name: '...',
            role: 'invitado',
            email: '',
            id: '',
        }
    },

    getters: {
        getloading: state => {
            return state.is_loading
        },
        getauth: state => {
            return state.auth
        },
        getuser: state => {
            return state.user
        }
    },

    mutations: {
        isloading: (state, status) => {
            state.is_loading = status
        },
        auth: (state, status) => {
            state.auth = status
        },
        user: (state, user) => {
            state.user = user
        },
    },

    actions: {
        isLoading: (context, status) => {
            context.commit('isloading', status)
        },
        setAuth: (context, status) => {
            context.commit('auth', status)
        },
        setUser: (context, user) => {
            context.commit('user', user)
        },
    }
}

export default modulo_sesion_usuario;