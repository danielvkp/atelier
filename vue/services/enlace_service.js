import axios from 'axios'

export const enlace_service = {

    async get_enlaces() {
        return axios.get(`get-enlaces`)
    },

    async save_enlace(data) {
        return axios.post(`save-enlace`, data)
    },

    async delete_enlace(id) {
        return axios.get(`delete-enlace/${id}`)
    },
}