export const headers_mixin = {
    data() {
        return {
            headers: [{
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
                    title: 'Duración',
                    key: 'duracion',
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