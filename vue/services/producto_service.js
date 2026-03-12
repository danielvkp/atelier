import axios from 'axios'

export const producto_service = {

    async get_productos() {
        return axios.get(`get-productos`)
    },

    async save_producto(data) {
        return axios.post(`save-producto`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    async get_producto(id) {
        return axios.get(`get-producto/${id}`)
    },

    async delete_producto(id) {
        return axios.get(`delete-producto/${id}`)
    },
}