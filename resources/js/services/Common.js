import BaseApi from './BaseApi'

export default {
    ViewStore(){
        return BaseApi.get('/masterfile/store')
    },
    ViewDepartment(){
        return BaseApi.get('/masterfile/department')
    },
    ViewProvince(){
        return BaseApi.get('/masterfile/province')
    },
    ViewBarangay(){
        return BaseApi.get('/masterfile/barangay')
    },
    ViewTown(){
        return BaseApi.get('/masterfile/town')
    },
    ViewTransportation(){
        return BaseApi.get('/masterfile/transportation')
    },
    ViewUserType(){
        return BaseApi.get('/user/usertype')
    },
    ViewEmployee(employee){
        return BaseApi.get(`/user/employees`, {params: {employee: employee} })
    },
    ViewPriceGroup(){
        return BaseApi.get('/masterfile/price_group')
    },

}
