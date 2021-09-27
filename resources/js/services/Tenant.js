import BaseApi from './BaseApi'

export default {
    saveInfo(tenant) {
        return BaseApi.post('/masterfile/tenant/save', tenant)
    },
    updateInfo(tenant) {
        return BaseApi.post('/masterfile/tenant/update', tenant)
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/tenant/show?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/masterfile/tenant/${id}`)
    },
}
