import axios from 'axios'
import NProgress from 'nprogress'
// import store from '../store'

const Http = axios.create({
    baseURL: process.env.MIX_APP_URL
});

Http.interceptors.request.use(config => { // Called on request
    NProgress.start()
    // store.commit('START_LOADING')
    return config
}, error => {
    NProgress.done()
    // store.commit('FINISH_LOADING')
    return Promise.reject(error);
});
Http.interceptors.response.use(response => { // Called on response
    NProgress.done()
    // store.commit('FINISH_LOADING')
    return response
}, error => {
    NProgress.done()
    // store.commit('FINISH_LOADING')
    return Promise.reject(error);
});

export default Http;
