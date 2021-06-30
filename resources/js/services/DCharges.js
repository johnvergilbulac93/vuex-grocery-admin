import BaseApi from './BaseApi'

export default {
    saveInfo(charge) {
        return BaseApi.post('/create/charge', charge)
    },
    updateInfo(tenant) {
        return BaseApi.post('/update/charge', tenant)
    },
    show(page, filterData) {
        return BaseApi.get(`/show/charges?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/charge/remove/${id}`)
    },
}