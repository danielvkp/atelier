import axios from 'axios'

const axiosInstance = axios.create({
    baseURL: 'api/',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Authorization': `Bearer ${localStorage.getItem('id_token')}`
    },
    withCredentials: true
});

export default axiosInstance