import ListaCategorias from '../componentes/ListaCategorias.vue'

const routes = [
    ...route('/lista-categorias', ListaCategorias, {
        auth: true,
    }),
]

function route(path, component = Default, meta = {}) {
    return [{
        path,
        component,
        meta
    }]
}

export default routes