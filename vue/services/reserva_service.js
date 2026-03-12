import axios from 'axios'

export const reserva_service = {

    async get_reservas() {
        return axios.get(`get-reservas`)
    },

    async update_reserva(data) {
        return axios.post(`update-reserva/${data.id}`, data)
    },

    async save_reserva(data) {
        return axios.post(`save-reserva`, data)
    },

    async delete_reserva(id) {
        return axios.get(`delete-reserva/${id}`)
    },

}