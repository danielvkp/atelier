export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Imagen',
                    key: 'cover',
                    sortable: false,
                }, {
                    title: 'Nombre',
                    key: 'nombre',
                    sortable: false
                },
                {
                    title: 'Menu',
                    key: 'menu',
                    sortable: false
                },
                {
                    text: 'Acciones',
                    value: 'action',
                    sortable: false
                },
                {
                    title: 'Tarifas',
                    value: 'tarifas',
                    sortable: false
                },
            ],
        }
    }
}