import BaseApi from './BaseApi'

export default {
    Price_changed_info(page, filterData) {
        return BaseApi.get(`/price_changed/info?page=${page}`, {
            params: filterData
        })
    },
    Item_not_available(page, filterData) {
        return BaseApi.get(`/item_not_available?page=${page}`, {
            params: filterData
        })
    },
    Price_changed_count(){
        return BaseApi.get('/price_changed/count')
    },
    ViewStore(){
        return BaseApi.get('/stores')
    },
    ViewDepartment(){
        return BaseApi.get('/departments')
    },
    ViewProvince(){
        return BaseApi.get('/province')
    },
    ViewBarangay(){
        return BaseApi.get('/barangay')
    },
    ViewTown(){
        return BaseApi.get('/town')
    },
    ViewTransportation(){
        return BaseApi.get('/transportations')
    },
    ViewUserType(){
        return BaseApi.get('/usertype')
    },
    ViewEmployee(employee){
        return BaseApi.get(`/employees`, {params: {employee: employee} })
    },
    ViewItemCategory(category){
        return BaseApi.get('/count/category')
    }
}
