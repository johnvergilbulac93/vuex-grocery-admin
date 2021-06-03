import BaseApi from './BaseApi'

export default {
    saveInfo(tenant) {
        return BaseApi.post('/tenant/create', tenant)
    },
    updateInfo(tenant) {
        return BaseApi.post('/tenant/update', tenant)
    },
    show(page, filterData) {
        return BaseApi.get(`/tenants?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/tenant/delete/${id}`)
    },
}
