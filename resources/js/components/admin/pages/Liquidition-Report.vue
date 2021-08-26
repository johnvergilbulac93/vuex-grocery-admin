<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class="container text-gray-800">
            <div class=" bg-gray-50 shadow-lg p-5 rounded ">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class="font-semibold text-lg "
                        >Liquidation Report</label
                    >
                </div>
                <div
                    class="flex sm:flex-col sm:space-y-5 md:space-y-0 md:flex-row justify-between items-center"
                >
                    <div
                        class=" w-3/4 flex sm:flex-col lg:flex-row sm:space-x-0 sm:space-y-5 lg:space-x-5 lg:space-y-0 space-x-5"
                    >
                        <div class="block sm:w-full md:w-56">
                            <label for="" class="font-semibold">Store</label>
                            <select
                                class="form"
                                v-model="filter.store"
                                tabindex="1"
                            >
                                <option value="">Choose Store</option>
                                <option
                                    v-for="(store, i) in Stores"
                                    :value="store.bunit_code"
                                    :key="i"
                                >
                                    {{ store.business_unit }}
                                </option>
                            </select>
                            <transition
                                enter-active-class="ease-in duration-300"
                                enter-class="opacity-0 "
                                enter-to-class="opacity-100"
                                leave-active-class="ease-out duration-500"
                                leave-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <Error
                                    :message="errors.store[0]"
                                    v-if="errors.store"
                                />
                            </transition>
                        </div>
                        <div class="block sm:w-full md:w-56 ">
                            <label for="" class="font-semibold"
                                >Date from</label
                            >
                            <input
                                type="date"
                                class="form"
                                tabindex="2"
                                v-model="filter.dateFrom"
                            />
                        </div>
                        <div class="block sm:w-full md:w-56">
                            <label for="" class="font-semibold">Date to</label>
                            <input
                                type="date"
                                class="form "
                                tabindex="3"
                                v-model="filter.dateTo"
                            />
                        </div>
                    </div>
                    <div class="flex space-x-1">
                        <button
                            tabindex="4"
                            @click="generate()"
                            class="h-10 px-4 py-2  focus:outline-none text-white  bg-blue-500 hover:bg-blue-600 rounded"
                        >
                            Generate
                        </button>

                        <button
                            tabindex="4"
                            class="h-10 px-4 py-2 flex items-center gap-1 disabled:opacity-50  focus:outline-none text-white  bg-green-500 hover:bg-green-600 rounded"
                            @click="printBtn"
                            v-if="transactions.b_unit != null"
                            :disabled="transactions.cashier_details.length"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                />
                            </svg>
                            Print
                        </button>
                    </div>
                </div>
                <hr class="mt-2" />

                <div class="mt-2" id="section-to-print">
                    <div class="flex justify-center items-center">
                        <div v-if="transactions.b_unit != null">
                            <center>
                                <h6 class="text-lg ">
                                    {{
                                        transactions.hasOwnProperty("b_unit") &&
                                            transactions.b_unit.business_unit
                                    }}
                                </h6>
                                <p>ALTURUSH GOODS ORDERING</p>
                                <p>LIQUIDATION REPORT</p>
                                <p class="text-center  ">
                                    {{ filter.dateFrom | formatDateNoTime }} To
                                    {{ filter.dateTo | formatDateNoTime }}
                                </p>
                            </center>
                        </div>
                    </div>
                    <div
                        class="mt-2"
                        id="body-content"
                        v-for="(cashier, index) in transactions.cashier_details"
                        :key="index"
                    >
                        <table
                            id="table-body-content"
                            class="min-w-full divide-y divide-gray-300"
                        >
                            <thead class="border bg-gray-100  tracking-normal">
                                <tr class="tr">
                                    <th class="p-2 border text-left">
                                        Cashier
                                    </th>
                                    <th class="p-2 border">Date</th>
                                    <th class="p-2 border">Ticket #</th>
                                    <th class="p-2 border text-left">
                                        Customer
                                    </th>
                                    <th class="p-2 border">Transaction #</th>
                                    <th class="p-2 border text-right">
                                        Gross Amt.
                                    </th>
                                    <th class="p-2 border text-right">Disc.</th>
                                    <th class="p-2 border text-right">
                                        Less Disc.
                                    </th>
                                    <th class="p-2 border text-right">
                                        Picking Charge
                                    </th>
                                    <th class="p-2 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <!-- <tr class="tr">
                                    <td
                                        colspan="10"
                                        class="text-center font-semibold tracking-normal"
                                    >
                                        NO DATA AVAILABLE
                                    </td>
                                </tr> -->
                                <tr
                                    v-for="(trans, index) in cashier"
                                    :key="index"
                                    class="tr"
                                >
                                    <td class="td ">
                                        {{ trans.name }}
                                    </td>
                                    <td class="td ">
                                        {{ trans.tickets[0].ticket }}
                                    </td>
                                    <td class="td ">
                                        {{ trans.tickets[0].customer }}
                                    </td>
                                    <td class="td ">
                                        {{ trans.tickets[0].receipt }}
                                    </td>
                                    <td class="td text-right">
                                        {{ orderedAmount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right ">
                                        {{ discountAmount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right">
                                        {{ lessDiscount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(
                                                trans.customer_bill[0]
                                                    .picking_charge
                                            ) | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(totalAmount(trans))
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr class="font-weight-bold tr">
                                    <th
                                        colspan="4"
                                        class="text-center p-2 border"
                                    >
                                        GRAND TOTAL:
                                    </th>
                                    <th class="p-2 border">
                                        {{ cashier.length }}
                                    </th>
                                    <th class="text-right p-2 border">
                                        {{
                                            totalOrderAmount(cashier)
                                                .orderAmount | toCurrency
                                        }}
                                    </th>
                                    <th class="text-right p-2 border">
                                        {{
                                            totalOrderAmount(cashier).discount
                                                | toCurrency
                                        }}
                                    </th>
                                    <th class="text-right p-2 border">
                                        {{
                                            totalOrderAmount(cashier)
                                                .lessDiscount | toCurrency
                                        }}
                                    </th>
                                    <th class="text-right p-2 border">
                                        {{
                                            totalOrderAmount(cashier)
                                                .pickupCharge | toCurrency
                                        }}
                                    </th>
                                    <th class="text-right p-2 border">
                                        {{
                                            totalOrderAmount(cashier)
                                                .grandTotal | toCurrency
                                        }}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <small class="text-xs flex justify-end mt-2"
                            >Run Time: {{ dateNow }}</small
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import Report from "../../../services/Report";
import Breadcrumb from "./../../../Usable/Breadcrumb";
export default {
    components: { Breadcrumb },
    name: "Liquidation-Report",
    data() {
        let routes = [
            {
                label: "Item Report",
                route: "/reports"
            },
            {
                label: "Liquidation Report",
                route: "/liquidition"
            },
            {
                label: "Accountability Report",
                route: "/accountability"
            },
            {
                label: "Total Order Report - REMITTED",
                route: "/transaction"
            }
        ];
        return {
            routes: routes,
            transactions: [],
            dateNow: null,
            filter: {
                dateFrom: null,
                dateTo: null,
                store: ""
            }
        };
    },
    computed: {
        ...mapState(["errors", "Stores"])
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapMutations(["SET_ERRORS",'CLEAR_ERRORS']),
        totalOrderAmount(orders) {
            let pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                grandTotal = 0;

            orders.forEach(order => {
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
        },
        lessDiscount(orders) {
            let orderedAmount = 0,
                discountAmount = 0,
                lessDiscount = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            orders.discount_amount.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );

            lessDiscount = orderedAmount - discountAmount;

            return lessDiscount;
        },
        discountAmount(orders) {
            let discountAmount = 0;
            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );
            return discountAmount;
        },
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
        printBtn() {
            window.print();
        },
        generate() {
            let filter = {
                store: this.filter.store,
                startDate: this.filter.dateFrom,
                endDate: this.filter.dateTo
            };
            if (this.filter.dateFrom > this.filter.dateTo) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                Report.liquidation_report(filter)
                    .then(res => {
                        this.transactions = res.data;
                        this.errors.store = "";
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.SET_ERRORS(error.response.data.errors);
                            setTimeout(() => {
                                 this.CLEAR_ERRORS()
                            }, 5000);
                        }
                    });
            }
        }
    },
    mounted() {
        this.getStore();
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
};
</script>
