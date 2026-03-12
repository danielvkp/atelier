import ListaUsuarios from '../componentes/ListaUsuarios.vue'
import FormUsuario from '../componentes/FormUsuario.vue'

const routes = [
    ...route('/lista-usuarios', ListaUsuarios, {
        auth: true,
    }),
    ...route('/guardar-usuario', FormUsuario, {
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