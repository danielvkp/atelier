import axios from 'axios'

export const historial_service = {

    async save_historial(query) {
        return axios.post(`save-historial-servicio`, query)
    },


    async delete_historial(id) {
        return axios.get(`delete-historial-servicio/${id}`)
    },

}