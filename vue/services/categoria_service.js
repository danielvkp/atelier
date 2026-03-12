import axios from 'axios'

export const categoria_service = {

    async get_categorias() {
        return axios.get(`get-categorias`)
    },

    async save_categoria(data) {
        return axios.post(`save-categoria`, data)
    },

    async get_categoria(id) {
        return axios.get(`get-categoria/${id}`)
    },

    async delete_categoria(id) {
        return axios.get(`delete-categoria/${id}`)
    },
}