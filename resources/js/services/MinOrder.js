import BaseApi from './BaseApi'

export default {
    saveInfo(minorder) {
        return BaseApi.post('/min_order/create', minorder)
    },
    updateInfo(minorder) {
        return BaseApi.post('/min_order/update', minorder)
    },
    show(page, filterData) {
        return BaseApi.get(`/show/min_order?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/min_order/delete/${id}`)
    },
}
