import ListaTarifas from '../componentes/ListaTarifas.vue'
import FormTarifa from '../componentes/FormTarifa.vue'

const routes = [
    ...route('/lista-tarifas', ListaTarifas, {
        auth: true,
    }),
    ...route('/guardar-tarifa', FormTarifa, {
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