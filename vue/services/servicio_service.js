import axios from 'axios'

export const servicio_service = {

    async get_servicios() {
        return axios.get(`get-servicios`)
    },

    async save_servicio(data) {
        return axios.post(`save-servicio`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    async get_servicio(id) {
        return axios.get(`get-servicio/${id}`)
    },

    async delete_servicio(id) {
        return axios.get(`delete-servicio/${id}`)
    },
}