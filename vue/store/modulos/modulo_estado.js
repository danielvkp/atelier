const modulo_estado = {
    strict: false,

    state: {
        errors: {
            errors: {

            }
        },

        login_errors: {
            message: null
        }

    },

    getters: {
        geterrors: state => state.errors,
        get_login_errors: state => state.login_errors
    },

    mutations: {
        is_errors: (state, errors) => state.errors = errors,

        clear_errors: state => state.errors = {
            errors: {

            }
        },

        has_login_errors: (state, errors) => state.login_errors = errors
    },

    actions: {
        setErrors: (context, errors) => context.commit('is_errors', errors),

        clearErrors: context => context.commit('clear_errors'),

        setLoginErrors: (context, errors) => context.commit('has_login_errors', errors)
    }
}

export default modulo_estado;