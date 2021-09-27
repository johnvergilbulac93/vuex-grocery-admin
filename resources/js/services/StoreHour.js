import BaseApi from './BaseApi'

export default {
     saveInfo(storehour) {
         return BaseApi.post('/masterfile/business_time/save', storehour)
     },
     show(page,filterData) {
         return BaseApi.get(`/masterfile/business_time/show?page=${page}`, { params: filterData })
     },
     delete(id) {
         return BaseApi.delete(`/masterfile/business_time/${id}`) 
     },
    changeStatus(status){
        return BaseApi.post('masterfile/business_time/status', status)
    }
 }
 