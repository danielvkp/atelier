import ListaProductos from '../componentes/ListaProductos.vue'
import FormProducto from '../componentes/FormProducto.vue'

const routes = [
    ...route('/lista-productos', ListaProductos, {
        auth: true,
    }),
    ...route('/guardar-producto', FormProducto, {
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