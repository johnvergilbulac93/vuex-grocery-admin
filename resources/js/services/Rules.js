import BaseApi from './BaseApi'

export default {
    minAmount(minAmount){
        return BaseApi.post('/min_order_amount',minAmount)
    },
    pickupCharge(chargeAmount){
        return BaseApi.post('/pickup_charge',chargeAmount)
    },
    maxOrder(maxOrder){
        return BaseApi.post('/max_order',maxOrder)
    },
    orderTimeCutoff(timeCutoff){
        return BaseApi.post('/order_time_cutoff',timeCutoff)
    },
    servingTimeCutoff(timeCutoff){
        return BaseApi.post('/serving_time',timeCutoff)
    }
}
