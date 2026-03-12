export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Nombre',
                    key: 'name',
                },
                {
                    title: 'Email',
                    key: 'email',
                },
                {
                    title: 'Tipo',
                    key: 'role',
                },
                {
                    title: 'Activo',
                    key: 'active',
                },
                {
                    title: 'Último login',
                    key: 'last_login',
                },
                {
                    text: 'Acciones',
                    value: 'action',
                    sortable: false
                },
            ],
        }
    }
}