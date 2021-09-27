import BaseApi from './BaseApi'

export default {
     saveInfo(storepricegroup) {
         return BaseApi.post('/masterfile/price_group/save', storepricegroup)
     },
     show(page,filterData) {
         return BaseApi.get(`/masterfile/price_group/show?page=${page}`, { params: filterData })
     },
     delete(id) {
         return BaseApi.delete(`masterfile/price_group/${id}`) 
     },
 }
 