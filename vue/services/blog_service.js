import axios from 'axios'

export const blog_service = {

    async get_blogs() {
        return axios.get(`get-blogs`)
    },

    async save_blog(data) {
        return axios.post(`save-blog`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    async get_blog(id) {
        return axios.get(`get-blog/${id}`)
    },

    async delete_blog(id) {
        return axios.get(`delete-blog/${id}`)
    },
}