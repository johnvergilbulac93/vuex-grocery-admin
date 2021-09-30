<template>
    <section v-if="Transactions.data.length">
        <div class="flex flex-col " v-if="filter.store === 'all'">
            <center>
                <h6 class="text-lg">
                    ALL STORES
                </h6>
                <p>
                    ALTURUSH GOODS ORDERING
                </p>
                <p>
                    TOTAL ORDERS REPORT(<span class="text-red-500">{{
                        filter.type
                    }}</span
                    >)
                </p>
                <p class="text-center ">
                    {{ filter.dateFrom | formatDateNoTime }}
                    To
                    {{ filter.dateTo | formatDateNoTime }}
                </p>
            </center>
            <div class="mt-5" id="transactions">
                <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="border bg-gray-100 tracking-normal">
                        <tr class="tr">
                            <th class="p-2 border text-left">
                                STORE NAME
                            </th>
                            <th class="p-2 border">
                                Total Orders
                            </th>

                            <th class="p-2 border text-right">
                                Gross Amount
                            </th>
                            <th class="p-2 border text-right">
                                Picking Charge
                            </th>
                            <th class="p-2 border text-right">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr
                            v-for="(byStore, i) in transactionByStore"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">
                                {{ byStore[0].business_unit }}
                            </td>
                            <td class="td text-center">
                                {{ byStore.length }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byStore).orderAmount
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byStore).pickupCharge
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byStore).grandTotal
                                        | toCurrency
                                }}
                            </td>
                        </tr>
                        <tr class="tr font-semibold">
                            <td class="td">
                                GRAND TOTAL
                            </td>
                            <td class="td text-center">
                                {{ orderSummary.gTotalTransaction }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.orderAmount | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.pickupCharge | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.grandTotal | toCurrency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <small
                    class="text-xs flex justify-end mt-2"
                    v-if="Transactions.data.length"
                    >Run Time: {{ filter.dateNow }}</small
                >
            </div>
        </div>
        <div class="flex flex-col " v-if="filter.store != 'all'">
            <center>
                <h6 class="text-lg">
                    {{
                        Transactions.hasOwnProperty("b_unit") &&
                            Transactions.b_unit.business_unit
                    }}
                </h6>
                <p>
                    ALTURUSH GOODS ORDERING
                </p>
                <p>
                    TOTAL ORDERS REPORT(<span class="text-red-500">{{
                        filter.type
                    }}</span
                    >)
                </p>
                <p class="text-center ">
                    {{ filter.dateFrom | formatDateNoTime }}
                    To
                    {{ filter.dateTo | formatDateNoTime }}
                </p>
            </center>
            <div class="mt-5" id="transactions">
                <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="border bg-gray-100  tracking-normal">
                        <tr class="tr">
                            <th class="p-2 border text-left">
                                Date
                            </th>
                            <th class="p-2 border ">
                                Total Order
                            </th>
                            <th class="p-2 border text-right">
                                Gross Amount
                            </th>
                            <th class="p-2 border text-right">
                                Picking Charge
                            </th>
                            <th class="p-2 border text-right">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr
                            v-for="(byMonth, i) in transactionByMonth"
                            :key="i"
                            class="tr"
                        >
                            <td class="td ">
                                {{
                                    byMonth[0].order_pickup | formatDateMonthOnly
                                }}
                            </td>
                            <td class="td text-center">
                                {{ byMonth.length }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byMonth).orderAmount
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byMonth).pickupCharge
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(byMonth).grandTotal
                                        | toCurrency
                                }}
                            </td>
                        </tr>
                        <tr class="tr font-semibold">
                            <td class="td">
                                GRAND TOTAL
                            </td>
                            <td class="td text-center">
                                {{ orderSummary.gTotalTransaction }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.orderAmount | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.pickupCharge | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{ orderSummary.grandTotal | toCurrency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <small
                    class="text-xs flex justify-end mt-2"
                    v-if="Transactions.data.length"
                    >Run Time: {{ filter.dateNow }}</small
                >
            </div>
        </div>
    </section>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "SummaryTransactionsReport",
    props: ["filter"],
    computed: {
        ...mapState(["Transactions"]),
        ...mapGetters([
            "transactionByStore",
            "transactionByMonth",
            "orderSummary"
        ])
    },
    methods: {
        orderedAmount(orders) {
            let orderedAmount = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            return orderedAmount;
        },
        totalOrderAmount(orders) {
            let pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                grandTotal = 0;
            orders.forEach(order => {
                // console.log(order);
                pickupCharge += parseFloat(
                    order.customer_bill[0].picking_charge
                );
                if (
                    order.hasOwnProperty("final_orders") &&
                    order.final_orders
                ) {
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
        },
        totalAmount(orders) {
            let total = 0,
                orderedAmount = 0,
                discountAmount = 0,
                pickingCharge = 0;
            if (orders.final_orders != null) {
                const uncancelledORders = orders.final_orders.filter(
                    order => order.canceled_status === 0
                );

                uncancelledORders.forEach(
                    order => (orderedAmount += parseFloat(order.total_price))
                );

                orders?.discount_amount?.forEach(
                    order => (discountAmount += parseFloat(order.discount))
                );

                orders?.customer_bill?.forEach(
                    order => (pickingCharge += parseFloat(order.picking_charge))
                );

                total = orderedAmount - discountAmount + pickingCharge;
                return parseFloat(total).toFixed(2);
            }
        }
    }
};
</script>
