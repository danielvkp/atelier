export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Titulo',
                    key: 'titulo',
                    sortable: false
                },
                {
                    title: 'Precio',
                    key: 'precio',
                    sortable: false
                },
                {
                    title: 'Tipo',
                    key: 'tipo',
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