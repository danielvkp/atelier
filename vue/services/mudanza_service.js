import axios from 'axios'

export const mudanza_service = {

    async search_mudanzas(page, query) {
        return axios.post(`search-mudanzas?page=${page}`, query)
    },

    async get_mudanzas(query) {
        return axios.post(`get-mudanzas`, query)
    },

    async finalizar_mudanza(id) {
        return axios.get(`finalizar-mudanza/${id}`)
    },

}