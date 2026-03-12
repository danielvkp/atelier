import ListaServicios from '../componentes/ListaServicios.vue'
import ListaTarifas from '../componentes/ListaTarifas.vue'
import FormServicio from '../componentes/FormServicio.vue'
import CalendarioReservas from '../componentes/CalendarioReservas.vue'

const routes = [
    ...route('/calendario-citas', CalendarioReservas, {
        auth: true,
    }),
    ...route('/lista-servicios', ListaServicios, {
        auth: true,
    }),
    ...route('/guardar-servicio', FormServicio, {
        auth: true,
    }),
    ...route('/guardar-tarifas', ListaTarifas, {
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