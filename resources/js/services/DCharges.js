import BaseApi from './BaseApi'

export default {
    saveInfo(charge) {
        return BaseApi.post('/masterfile/delivery_charge/save', charge)
    },
    updateInfo(tenant) {
        return BaseApi.post('/masterfile/delivery_charge/update', tenant)
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/delivery_charge/show?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/masterfile/delivery_charge/${id}`)
    },
}