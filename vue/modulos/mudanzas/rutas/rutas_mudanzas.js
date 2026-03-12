import ListaMudanzas from '../componentes/ListaMudanzas.vue'
import CalendarioMudanzas from '../componentes/CalendarioMudanzas.vue'

const routes = [
    ...route('/lista-mudanzas', ListaMudanzas, {
        auth: true,
    }),
    ...route('/calendario-mudanzas', CalendarioMudanzas, {
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