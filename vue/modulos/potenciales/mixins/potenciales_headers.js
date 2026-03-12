export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'ID',
                    key: 'id',
                    sortable: false
                }, {
                    title: 'Nombre',
                    key: 'nombre',
                    sortable: false
                },
                {
                    title: 'Email',
                    key: 'email',
                    sortable: false
                },
                {
                    title: 'Teléfono',
                    key: 'telefono',
                    sortable: false
                },
                {
                    title: 'Estado',
                    key: 'seguimiento',
                    sortable: false
                },
                {
                    title: 'Medio',
                    key: 'medio',
                    sortable: false
                },
                {
                    title: 'Fecha estimada',
                    key: 'fecha_mudanza',
                    sortable: false
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