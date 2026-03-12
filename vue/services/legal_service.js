import axios from 'axios'

export const legal_service = {

    async get_legal() {
        return axios.get(`get-legal`)
    },

    async save_legal(data) {
        return axios.post(`save-legal`, data)
    }
}