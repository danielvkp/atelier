import ListaSecciones from '../componentes/ListaSecciones.vue'
import FormSeccion from '../componentes/FormSeccion.vue'

const routes = [
    ...route('/lista-secciones', ListaSecciones, {
        auth: true,
    }),
    ...route('/guardar-seccion', FormSeccion, {
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