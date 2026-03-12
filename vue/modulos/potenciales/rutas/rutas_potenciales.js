import ListaPotenciales from '../componentes/ListaPotenciales.vue'
import FormPotencial from '../componentes/FormPotencial.vue'

const routes = [
    ...route('/lista-potenciales', ListaPotenciales, {
        auth: true,
    }),
    ...route('/guardar-cliente', FormPotencial, {
        auth: true,
    })
]

function route(path, component = Default, meta = {}) {
    return [{
        path,
        component,
        meta
    }]
}

export default routes