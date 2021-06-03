import axios from 'axios'

const Http = axios.create({
     baseURL: process.env.MIX_APP_URL
});

export default Http;