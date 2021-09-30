export const orderSummary = state => {
    let grandTotal = 0,
        pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0;

    if (state.Transactions.data.length) {
        state.Transactions.data.forEach(transaction => {
            pickupCharge += parseFloat(
                transaction.customer_bill[0].picking_charge
            );
            if (
                transaction.hasOwnProperty("final_orders") &&
                transaction.final_orders
            ) {
                transaction.final_orders
                    .filter(order => order.canceled_status === 0)
                    .forEach(order => {
                        orderAmount += parseFloat(order.total_price);
                    });
            }
            if (
                transaction.hasOwnProperty("discount_amount") &&
                transaction.discount_amount
            ) {
                transaction.discount_amount.forEach(order => {
                    discount += parseFloat(order.discount);
                });
            }
        });
        lessDiscount = orderAmount - discount;
        grandTotal = orderAmount - discount + pickupCharge;
        return {
            grandTotal,
            orderAmount,
            discount,
            pickupCharge,
            lessDiscount
        };
    }
};
export const transactionByStore = state => {
    if (state.Transactions.data.length) {
        return _.groupBy(state.Transactions.data, "acroname");
    }
};
export const transactionByMonth = state => {
    if (state.Transactions.data.length) {
        return _.groupBy(state.Transactions.data, function(d) {
            return moment(d.order_pickup).month();
        });
    }
};
export const totalOrderAmount = state => {
    let pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0,
        grandTotal = 0;

    if (state.Liquidation.cashier_details.length) {
        state.Liquidation.cashier_details.forEach(order => {
            pickupCharge += parseFloat(order.customer_bill[0].picking_charge);
            if (order.hasOwnProperty("final_orders") && order.final_orders) {
                order.final_orders
                    .filter(order => order.canceled_status === 0)
                    .forEach(order => {
                        orderAmount += parseFloat(order.total_price);
                    });
            }
            if (
                order.hasOwnProperty("discount_amount") &&
                order.discount_amount
            ) {
                order.discount_amount.forEach(order => {
                    discount += parseFloat(order.discount);
                });
            }
        });

        lessDiscount = orderAmount - discount;
        grandTotal = orderAmount - discount + pickupCharge;
        return {
            grandTotal,
            orderAmount,
            discount,
            pickupCharge,
            lessDiscount
        };
    }
};
