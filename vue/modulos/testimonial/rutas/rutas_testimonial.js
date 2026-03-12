import ListaTestimonial from '../componentes/ListaTestimonial.vue'
import FormTestimonial from '../componentes/FormTestimonial.vue'

const routes = [
    ...route('/lista-review', ListaTestimonial, {
        auth: true,
    }),
    ...route('/guardar-review', FormTestimonial, {
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