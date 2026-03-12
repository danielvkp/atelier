import FormLegal from '../componentes/FormLegal.vue'

const routes = [
    ...route('/legal', FormLegal, {
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