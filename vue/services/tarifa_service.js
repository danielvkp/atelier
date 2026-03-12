import axios from 'axios'

export const tarifa_service = {

    async get_tarifas() {
        return axios.get(`get-tarifas`)
    },

    async save_tarifa(data) {
        return axios.post(`save-tarifa`, data)
    },

    async get_tarifa(id) {
        return axios.get(`get-tarifa/${id}`)
    },

    async delete_tarifa(id) {
        return axios.get(`delete-tarifa/${id}`)
    },
}