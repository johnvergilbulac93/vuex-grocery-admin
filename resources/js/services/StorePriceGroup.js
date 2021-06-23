import BaseApi from './BaseApi'

export default {
     saveInfo(storepricegroup) {
         return BaseApi.post('/price_group/save', storepricegroup)
     },
     show(page,filterData) {
         return BaseApi.get(`/show/price_group?page=${page}`, { params: filterData })
     },
     delete(id) {
         return BaseApi.delete(`/business_time/delete/${id}`) 
     },
 }
 