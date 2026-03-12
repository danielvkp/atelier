import axios from 'axios'

export const user_service = {

    async search_user(page, query) {
        return axios.post(`search-usuarios?page=${page}`, query)
    },

    async save_user(data) {
        return axios.post(`save-usuario`, data)
    },

    async get_user(id) {
        return axios.get(`get-usuario/${id}`)
    },

    async get_users_by_role(role) {
        return axios.get(`get-usuarios-by-role/${role}`)
    },

    async delete_user(id) {
        return axios.get(`delete-usuario/${id}`)
    },
}