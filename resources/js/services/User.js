import BaseApi from './BaseApi'

export default {
    saveInfo(user) {
        return BaseApi.post('/user/create', user)
    },
    updateInfo(user) {
        return BaseApi.post('/user/update', user)
    },
    show(page, filterData) {
        return BaseApi.get(`/show/users?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/user/delete/${id}`)
    },
    activeUser(user) {
        return BaseApi.post('/active', user)
    },
    inactiveUser(user) {
        return BaseApi.post('/inactive', user)
    },
}
