import axios from 'axios'

export const tarifa_servicio_service = {

    async all_tarifas() {
        return axios.get(`get-tarifas-servicios`)
    },

    async get_tarifas(id) {
        return axios.get(`get-tarifas-servicio/${id}`)
    },

    async save_tarifa(id, data) {
        return axios.post(`save-tarifa-servicio/${id}`, data)
    },

    async delete_tarifa(id) {
        return axios.get(`delete-tarifa-servicio/${id}`)
    },
}