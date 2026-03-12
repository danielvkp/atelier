import axios from 'axios'

export const potencial_service = {

    async search_potencial(page, query) {
        return axios.post(`search-potenciales?page=${page}`, query)
    },

    async get_potencial(id) {
        return axios.get(`get-potencial/${id}`)
    },

    async delete_potencial(id) {
        return axios.get(`delete-potencial/${id}`)
    },

    async save_cliente(query) {
        return axios.post(`save-cliente`, query)
    },

}