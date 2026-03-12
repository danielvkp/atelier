import axios from 'axios'

export const empleado_service = {

    async get_empleados() {
        return axios.get(`get-empleados`)
    },

    async save_empleado(data) {
        return axios.post(`save-empleado`, data)
    },

    async delete_empleado(id) {
        return axios.get(`delete-empleado/${id}`)
    },
}