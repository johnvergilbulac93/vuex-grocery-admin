import BaseApi from './BaseApi'

export default {
     saveInfo(storehour) {
         return BaseApi.post('/business_time/save', storehour)
     },
     show(page,filterData) {
         return BaseApi.get(`/business_time?page=${page}`, { params: filterData })
     },
     delete(id) {
         return BaseApi.delete(`/business_time/delete/${id}`) 
     },
     storeActive(status){
         return BaseApi.post('/business_time/active', status)
     },
     storeInactive(status){
        return BaseApi.post('/business_time/inactive', status)
    }
 }
 