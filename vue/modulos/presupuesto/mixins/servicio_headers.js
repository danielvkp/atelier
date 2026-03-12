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
                    title: 'Precio',
                    key: 'precio',
                    sortable: false
                },
                {
                    title: 'Activo',
                    key: 'active',
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