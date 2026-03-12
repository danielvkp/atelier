const modulo_snackbar = {
    strict: false,

    state: {
        snackbar: {
            status: false,
            color: 'green',
            text: ''
        }
    },

    getters: {
        get_snackbar: state => state.snackbar,
    },

    mutations: {
        set_snackbar: (state, payload) => {
            state.snackbar.status = payload.status
            state.snackbar.color = payload.color
            state.snackbar.text = payload.text
        }
    },

    actions: {
        success: (context, text) => context.commit('set_snackbar', {
            color: 'green',
            text: text,
            status: true
        }),

        error: (context, text) => context.commit('set_snackbar', {
            color: 'red lighten-1',
            text: text,
            status: true
        }),

        warning: (context, text) => context.commit('set_snackbar', {
            color: 'orange',
            text: text,
            status: true
        }),

        close_toast: (context) => context.commit('set_snackbar', {
            color: 'success',
            text: null,
            status: false
        })
    }
}

export default modulo_snackbar;