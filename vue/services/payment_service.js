import axios from 'axios'

export const payment_service = {

    async get_payments(data) {
        return axios.post(`get-payments`, data)
    },

    async get_excel(data) {
        return axios.post(`generate-excel`, data)
    },
}