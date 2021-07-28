import BaseApi from './BaseApi'

export default {
    loadRules(){
        return BaseApi.get('/rules')
    },
    update(rule){
        return BaseApi.post('/rules/update',rule)
    }
}
