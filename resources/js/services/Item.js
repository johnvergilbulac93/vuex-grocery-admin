import BaseApi from './BaseApi'

export default {
    show(page, filterData) {
        return BaseApi.get(`/item/show?page=${page}`, {
            params: filterData
        })
    },
    uploadImage(formData){
        return BaseApi.post('/item/image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    Price_changed_count(){
        return BaseApi.get('/item/change_price/count')
    },
    Price_changed_info(page, filterData) {
        return BaseApi.get(`/item/change_price/show?page=${page}`, {
            params: filterData
        })
    },
    ViewItemCategory(){
        return BaseApi.get('/item/category')
    },
    Item_not_available(page, filterData) {
        return BaseApi.get(`/item/per_store/item_not_available/show?page=${page}`, {
            params: filterData
        })
    },
    change_status(item){
        return BaseApi.post('/item/change_status', item)
    },
    change_status_item_not_available(item){
        return BaseApi.post('/item/per_store/change_status', item)
    },
    show_item_enable_per_uom(page, filterData) {
        return BaseApi.get(`/item/disable_uom/show?page=${page}`, {
            params: filterData
        })
    },
    show_item_disable_per_uom(page, filterData) {
        return BaseApi.get(`/item/enable_uom/show?page=${page}`, {
            params: filterData
        })
    },
    item_disable_per_uom(itemcode){
        return BaseApi.post('/item/disable_uom', itemcode)
    },
    item_enable_per_uom(itemcode){
        return BaseApi.post('/item/enable_uom', itemcode)
    },
    store_item_masterfile(page, filterData) {
        return BaseApi.get(`/item/per_store/show?page=${page}`, {
            params: filterData
        })
    },
    store_item_disable_all(itemcode){
        return BaseApi.post('/item/per_store/item_disabled', itemcode)
    },
    store_item_enable_all(itemcode){
        return BaseApi.post('/item/per_store/item_enabled', itemcode)
    },

    tag_store_item_disable(itemcode){
        return BaseApi.post('/item/per_store/item_tag_disabled', itemcode)
    },
    tag_store_item_enable(itemcode){
        return BaseApi.delete('/item/per_store/item_tag_enabled/' + itemcode)
    },
}
