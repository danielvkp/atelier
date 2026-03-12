export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Nombre',
                    key: 'nombre',
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