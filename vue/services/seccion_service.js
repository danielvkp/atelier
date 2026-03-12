import axios from 'axios'

export const seccion_service = {

    async get_secciones() {
        return axios.get(`get-secciones`)
    },

    async save_seccion(data) {
        return axios.post(`save-seccion`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    async get_seccion(id) {
        return axios.get(`get-seccion/${id}`)
    },

    async delete_seccion(id) {
        return axios.get(`delete-seccion/${id}`)
    },
}