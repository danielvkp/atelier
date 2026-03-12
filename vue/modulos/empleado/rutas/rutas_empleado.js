import ListaEmpleados from '../componentes/ListaEmpleados.vue'

const routes = [
    ...route('/lista-empleados', ListaEmpleados, {
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