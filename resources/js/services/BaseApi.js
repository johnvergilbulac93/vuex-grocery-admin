import axios from 'axios'
import NProgress from 'nprogress'
import store from '../store'

const Http = axios.create({
    baseURL: process.env.MIX_APP_URL
});

Http.interceptors.request.use(config => { // Called on request
    NProgress.start()
    store.commit('CHECK_SESSION', false)

    return config
}, error => {
    NProgress.done()
    store.commit('CHECK_SESSION', false)

    return Promise.reject(error);
});
Http.interceptors.response.use(response => { // Called on response
    NProgress.done()
    store.commit('CHECK_SESSION', false)

    return response
}, error => {
    NProgress.done()
    store.commit('CHECK_SESSION', false)

    const {status} = error.response;
    let  UNAUTHORIZED = 401
    if(status === UNAUTHORIZED){
        store.commit('CHECK_SESSION', true)
    }
    return Promise.reject(error);
});

export default Http;
