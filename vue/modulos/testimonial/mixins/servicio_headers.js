export const headers_mixin = {
    data() {
        return {
            headers: [{
                    title: 'Nombre',
                    key: 'nombre',
                    sortable: false
                },
                {
                    title: 'Descripcion',
                    key: 'descripcion',
                    sortable: false,
                    width: 400

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