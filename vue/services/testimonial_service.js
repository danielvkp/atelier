import axios from 'axios'

export const testimonial_service = {

    async get_testimonials() {
        return axios.get(`get-testimonials`)
    },

    async save_testimonial(data) {
        return axios.post(`save-testimonial`, data)
    },

    async get_testimonial(id) {
        return axios.get(`get-testimonial/${id}`)
    },

    async delete_testimonial(id) {
        return axios.get(`delete-testimonial/${id}`)
    },
}