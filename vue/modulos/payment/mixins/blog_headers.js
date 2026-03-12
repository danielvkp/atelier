export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Orden',
                    key: 'nro_orden',
                    sortable: false,
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
                    title: 'Detalles',
                    key: 'detalles',
                    sortable: false,
                    width: 200
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