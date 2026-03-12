import axios from 'axios'

export const auth_service = {

    async send_code(query) {
        return axios.post(`send-code`, query)
    },

    async verify_code(query) {
        return axios.post(`verify-code`, query)
    },

    async set_password(query, token) {
        return axios.post(`set-password`, query, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })
    },

}