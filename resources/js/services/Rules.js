import BaseApi from './BaseApi'

export default {
    loadRules(){
        return BaseApi.get('/masterfile/rule/show')
    },
    update(rule){
        return BaseApi.post('/masterfile/rule/update',rule)
    },
    getRuleByID(id){
        return BaseApi.get('/masterfile/rule/show/' + id)
    }
}
