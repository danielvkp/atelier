import ListaPayments from '../componentes/ListaPayments.vue'

const routes = [
    ...route('/lista-compras', ListaPayments, {
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