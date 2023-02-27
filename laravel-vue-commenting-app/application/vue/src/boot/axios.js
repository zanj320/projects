import axios from 'axios'
import { useUserStore } from '../stores/UserStore.js'

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true,
    headers: { Accept: 'application/json' }
})

api.interceptors.request.use(function (config) {
    const UserStore = useUserStore()
    const token = UserStore.token
    config.headers.Authorization = `Bearer ` + localStorage.getItem('token')
  
    return config
})

export { api }