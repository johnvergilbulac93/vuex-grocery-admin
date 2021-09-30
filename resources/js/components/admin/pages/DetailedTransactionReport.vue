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
                <table
                    class="min-w-full divide-y divide-gray-300 mb-10"
                    v-for="(byStore, i) in transactionByStore"
                    :key="i"
                >
                    <thead
                        class="border  bg-gray-100  tracking-wide font-poppins"
                    >
                        <tr class="tr">
                            <th colspan="6" class=" p-2 border">
                                <span
                                    class="font-semibold flex justify-start"
                                    >{{ byStore[0].business_unit }}</span
                                >
                            </th>
                        </tr>
                        <tr class="td">
                            <th class="p-2 text-center border">
                                Date
                            </th>
                            <th class="p-2 text-left border">
                                Customer
                            </th>
                            <th class="p-2 text-center border">
                                Transaction #.
                            </th>
                            <th class="p-2 text-right border">
                                Gross Amount
                            </th>
                            <th class="p-2 text-right border">
                                Picking Charge
                            </th>
                            <th class="p-2 text-right border">
                                Total Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr v-if="!byStore.length" class="tr">
                            <td colspan="6" class="td">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(trans, innerIndex) in byStore"
                            :key="innerIndex"
                            class="tr"
                        >
                            <td class="td text-center">
                                {{ trans.order_pickup | formatDateNoTime }}
                            </td>
                            <td class="td text-left">
                                {{ trans.customer }}
                            </td>
                            <td class="td text-center">
                                {{ trans.receipt }}
                            </td>
                            <td class="td text-right">
                                {{ orderedAmount(trans) | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{
                                    parseFloat(
                                        trans.customer_bill[0].picking_charge
                                    ) | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    parseFloat(totalAmount(trans)) | toCurrency
                                }}
                            </td>
                        </tr>
                        <tr class="tr font-semibold">
                            <td colspan="2" class="td ">
                                Sub Total
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
                    </tbody>
                </table>
                <section>
                    <table
                        class="min-w-full divide-y divide-gray-300"
                        v-if="!Transactions.data.length"
                    >
                        <thead class="border  bg-gray-100 tracking-normal">
                            <tr class="tr">
                                <th colspan="2" class="p-2 border"></th>
                                <th class="p-2 border">
                                    Transaction #
                                </th>
                                <th class="p-2 border text-right">
                                    Gross Amount
                                </th>
                                <th class="p-2 border text-right">
                                    Picking Charge
                                </th>
                                <th class="p-2 border text-right">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr class="tr">
                                <td colspan="2" class="td font-semibold">
                                    GRAND TOTAL
                                </td>
                                <td class="td font-semibold text-center">
                                    {{ Transactions.data.length }}
                                </td>
                                <td class="td font-semibold text-right">
                                    {{ orderSummary.orderAmount | toCurrency }}
                                </td>
                                <td class="td font-semibold text-right">
                                    {{ orderSummary.pickupCharge | toCurrency }}
                                </td>
                                <td class="td font-semibold text-right">
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
                </section>
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
                <p class="text-center">
                    {{ filter.dateFrom | formatDateNoTime }}
                    To
                    {{ filter.dateTo | formatDateNoTime }}
                </p>
            </center>
            <div class="mt-5 " id="transactions">
                <table
                    class="min-w-full divide-y divide-gray-300 mb-10"
                    v-for="(byMonth, i) in transactionByMonth"
                    :key="i"
                >
                    <thead class="border bg-gray-100  tracking-normal">
                        <tr class="tr ">
                            <th class="p-2 border text-center">
                                Date
                            </th>
                            <th class="p-2 border text-left">
                                Customer
                            </th>
                            <th class="p-2 border text-center">
                                Transaction #
                            </th>
                            <th class="p-2 border text-right">
                                Gross Amount
                            </th>
                            <th class="p-2 border text-right">
                                Pick-up Charge
                            </th>
                            <th class="p-2 border text-right">
                                Total Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr v-if="!byMonth.length" class="tr">
                            <td colspan="6" class="td">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(trans, innerIndex) in byMonth"
                            :key="innerIndex"
                            class="tr"
                        >
                            <td class="td text-center">
                                {{ trans.order_pickup | formatDateNoTime }}
                            </td>
                            <td class="td">
                                {{ trans.customer }}
                            </td>
                            <td class="td text-center">
                                {{ trans.receipt }}
                            </td>
                            <td class="td text-right">
                                {{ orderedAmount(trans) | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{
                                    parseFloat(
                                        trans.customer_bill[0].picking_charge
                                    ) | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    parseFloat(totalAmount(trans)) | toCurrency
                                }}
                            </td>
                        </tr>
                        <tr
                            v-if="
                                Transactions.hasOwnProperty('data') &&
                                    Transactions.data.length
                            "
                            class="tr"
                        >
                            <td colspan="2" class="td font-semibold">
                                Sub Total
                            </td>
                            <td class="td text-center font-semibold">
                                {{ byMonth.length }}
                            </td>
                            <td class="td text-right font-semibold">
                                {{
                                    totalOrderAmount(byMonth).orderAmount
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right font-semibold">
                                {{
                                    totalOrderAmount(byMonth).pickupCharge
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right font-semibold">
                                {{
                                    totalOrderAmount(byMonth).grandTotal
                                        | toCurrency
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <table
                        class="min-w-full divide-y divide-gray-300 "
                        v-if="!Transactions.data.length"
                    >
                        <thead
                            class="border  bg-gray-100  tracking-wide font-poppins"
                        >
                            <tr class="tr">
                                <th colspan="2" class="p-2"></th>
                                <th class="p-2">
                                    Transaction #
                                </th>
                                <th class="p-2">
                                    Gross Amount
                                </th>
                                <th class="p-2">
                                    Picking Charge
                                </th>
                                <th class="p-2">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr class="tr">
                                <td colspan="2" class="td font-semibold ">
                                    Grand Total
                                </td>
                                <td class="td  text-center font-semibold">
                                    {{ Transactions.data.length }}
                                </td>
                                <td class="td text-center font-semibold">
                                    {{ orderSummary.orderAmount | toCurrency }}
                                </td>
                                <td class="td text-center font-semibold">
                                    {{ orderSummary.pickupCharge | toCurrency }}
                                </td>
                                <td class="td text-center font-semibold">
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
        </div>
    </section>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "DetailedTransactionsReport",
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
