import FormPresupuesto from '../componentes/FormPresupuesto.vue'

const routes = [
    ...route('/crear-presupuesto', FormPresupuesto, {
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