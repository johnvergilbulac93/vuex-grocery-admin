import BaseApi from './BaseApi'

export default {
    loadRules(){
        return BaseApi.get('/show/rules')
    },
    update(rule){
        return BaseApi.post('/rules/update',rule)
    }
}
