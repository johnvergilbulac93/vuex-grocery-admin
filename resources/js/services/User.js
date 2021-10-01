import BaseApi from './BaseApi'

export default {
    saveInfo(user) {
        return BaseApi.post('/user/create', user)
    },
    updateInfo(user) {
        return BaseApi.post('/user/update', user)
    },
    show(page, filterData) {
        return BaseApi.get(`/user/show?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/user/delete/${id}`)
    },
    userStatus(user){
        return BaseApi.post('/user/status', user)
    },
    changePassword(user) {
        return BaseApi.post('/user/change_password', user)
    },
    changeUsername(user) {
        return BaseApi.post('/user/change_username', user)
    },
    profilePhoto(formData,axiosSource) {
        return BaseApi.post('/user/profile_image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            cancelToken: axiosSource.token
        })
    }
}
