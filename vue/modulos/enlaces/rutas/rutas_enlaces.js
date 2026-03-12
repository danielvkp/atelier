import ListaEnlaces from '../componentes/ListaEnlaces.vue'

const routes = [
    ...route('/lista-enlaces', ListaEnlaces, {
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