export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Imagen',
                    key: 'cover',
                    sortable: false,
                }, {
                    title: 'Titulo',
                    key: 'nombre',
                    sortable: false
                },
                {
                    title: 'Url',
                    key: 'slug',
                    sortable: false
                },
                {
                    title: 'Precio',
                    key: 'precio',
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