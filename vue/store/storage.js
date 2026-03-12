import modulo_estado from './modulos/modulo_estado'
import modulo_sesion_usuario from './modulos/modulo_sesion_usuario'
import modulo_snackbar from './modulos/modulo_snackbar'

import {
    createStore
} from 'vuex'

const store = createStore({
    strict: false,
    modules: {
        sesion_usuario: modulo_sesion_usuario,
        estado: modulo_estado,
        toast: modulo_snackbar
    },
})

export default store