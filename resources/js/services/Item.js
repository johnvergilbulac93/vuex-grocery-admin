import BaseApi from './BaseApi'

export default {
    saveInfo(user) {
        return BaseApi.post('/user/create', user)
    },
    updateInfo(user) {
        return BaseApi.post('/user/update', user)
    },
    show(page, filterData) {
        return BaseApi.get(`/show/central_item?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/user/delete/${id}`)
    },
    uploadImage(formData){
        return BaseApi.post('/upload/image_item', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    change_status(item){
        return BaseApi.post('/change_status', item)
    },
    change_status_item_not_available(item){
        return BaseApi.post('/change_status_item_not_available', item)
    },
    show_item_enable_per_uom(page, filterData) {
        return BaseApi.get(`/show/item_disable_per_uom?page=${page}`, {
            params: filterData
        })
    },
    show_item_disable_per_uom(page, filterData) {
        return BaseApi.get(`/show/item_enable_per_uom?page=${page}`, {
            params: filterData
        })
    },
    item_disable_per_uom(itemcode){
        return BaseApi.post('/disable_item_per_uom', itemcode)
    },
    item_enable_per_uom(itemcode){
        return BaseApi.post('/enable_item_per_uom', itemcode)
    },
    store_item_masterfile(page, filterData) {
        return BaseApi.get(`/show/store_item?page=${page}`, {
            params: filterData
        })
    },
    store_item_disable_all(itemcode){
        return BaseApi.post('/store/disable_item', itemcode)
    },
    store_item_enable_all(itemcode){
        return BaseApi.post('/store/enable_item', itemcode)
    },
    tag_store_item_disable(itemcode){
        return BaseApi.post('/store/tag_disable', itemcode)
    },
    tag_store_item_enable(itemcode){
        return BaseApi.delete('/store/tag_enable/' + itemcode)
    },
}
