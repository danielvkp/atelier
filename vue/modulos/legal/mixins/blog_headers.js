export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Imagen',
                    key: 'cover',
                    sortable: false,
                }, {
                    title: 'Titulo',
                    key: 'titulo',
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