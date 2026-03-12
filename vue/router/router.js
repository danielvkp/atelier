import {
    createWebHashHistory,
    createRouter
} from 'vue-router'

import auth from '../auth/auth.js'

import Login from '../componentes/login/Login.vue'
import Recover from '../componentes/login/Recover.vue'
import Inicio from '../componentes/inicio/Inicio.vue'

/* Rutas */
import rutas_usuarios from '../modulos/usuarios/rutas/rutas_usuarios.js'
import rutas_potenciales from '../modulos/potenciales/rutas/rutas_potenciales.js'
import rutas_mudanzas from '../modulos/mudanzas/rutas/rutas_mudanzas.js'
import rutas_servicios from '../modulos/servicios/rutas/rutas_servicios.js'
import rutas_presupuesto from '../modulos/presupuesto/rutas/rutas_presupuesto.js'
import rutas_tarifa from '../modulos/tarifa/rutas/rutas_tarifa.js'
import rutas_testimonial from '../modulos/testimonial/rutas/rutas_testimonial.js'
import rutas_categoria from '../modulos/categoria/rutas/rutas_categoria.js'
import rutas_blog from '../modulos/blog/rutas/rutas_blog.js'
import rutas_legal from '../modulos/legal/rutas/rutas_legal.js'
import rutas_seccion from '../modulos/seccion/rutas/rutas_seccion.js'
import rutas_producto from '../modulos/producto/rutas/rutas_producto.js'
import rutas_payment from '../modulos/payment/rutas/rutas_payment.js'
import rutas_enlaces from '../modulos/enlaces/rutas/rutas_enlaces.js'
import rutas_empleado from '../modulos/empleado/rutas/rutas_empleado.js'
/* Rutas */

const routes = [
    ...route('/', Inicio, {
        auth: true,
        //requiresAdmin: true
    }),
    ...route('/login', Login),
    ...route('/recuperar-password', Recover),
    ...rutas_usuarios,
    ...rutas_potenciales,
    ...rutas_mudanzas,
    ...rutas_servicios,
    ...rutas_presupuesto,
    ...rutas_tarifa,
    ...rutas_testimonial,
    ...rutas_categoria,
    ...rutas_blog,
    ...rutas_legal,
    ...rutas_seccion,
    ...rutas_producto,
    ...rutas_payment,
    ...rutas_enlaces,
    ...rutas_empleado
]

function route(path, component = Default, meta = {}) {
    return [{
        path,
        component,
        meta
    }]
}

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.meta.auth) {

        const authUser = localStorage.getItem('role')

        if (!auth.authenticated()) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            })
        } else if (to.meta.req_user) {
            (authUser == 'user') ? next(): next('/404')
        } else if (to.meta.req_comercial) {
            (authUser == 'docente') ? next(): next('/404')
        } else {
            next()
        }
    } else {
        next()
    }
})


export default router