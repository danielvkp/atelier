import ListaBlogs from '../componentes/ListaBlogs.vue'
import FormBlog from '../componentes/FormBlog.vue'

const routes = [
    ...route('/lista-blogs', ListaBlogs, {
        auth: true,
    }),
    ...route('/guardar-blog', FormBlog, {
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