import axios from 'axios'

const axioslogika = axios.create({
  baseURL: 'http://localhost/sas',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  },
})
axioslogika.defaults.withCredentials = true
export default axioslogika
