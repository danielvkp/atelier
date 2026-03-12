import axios from 'axios'

export const dashboard_service = {
    async get_dashboard() {
        return axios.get(`get-dashboard-counts`)
    },
}