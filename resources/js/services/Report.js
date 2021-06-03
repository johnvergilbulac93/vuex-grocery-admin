import BaseApi from './BaseApi'

export default {
    show_item_store(filter) {
        return BaseApi.get('/report/item', {
            params: filter
        })
    },
    liquidation_report(filter) {
        return BaseApi.get('/report/liquidation', {
            params: filter
        })
    },
    accountability_report(filter) {
        return BaseApi.get('/report/accountability', {
            params: filter
        })
    },
    total_orders_report(filter) {
        return BaseApi.get('/report/transactions', {
            params: filter
        })
    },
    store_item_report(filter) {
        return BaseApi.get('/report/store/item_report', {
            params: filter
        })
    },
    store_liquidation_report(filter) {
        return BaseApi.get('/report/store/liquidation', {
            params: filter
        })
    },
    store_cashier_accountability_report(filter) {
        return BaseApi.get('/report/store/accountability', {
            params: filter
        })
    },



}
