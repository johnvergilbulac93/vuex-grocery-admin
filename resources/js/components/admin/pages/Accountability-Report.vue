<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class="container text-gray-800">
            <div class=" bg-gray-50 shadow-lg p-5 rounded">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class="font-semibold text-lg "
                        >Accountability Report</label
                    >
                </div>
                <div
                    class="flex sm:flex-col sm:space-y-5 md:space-y-0 md:flex-row justify-between items-center"
                >
                    <div
                        class=" w-3/4 flex sm:flex-col lg:flex-row sm:space-x-0 sm:space-y-5 lg:space-x-5 lg:space-y-0 space-x-5"
                    >
                        <div class="block w-1/4 sm:w-full md:w-1/2">
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
                        <div class="block w-1/4 sm:w-full md:w-1/2 ">
                            <label for="" class="font-semibold"
                                >Date from</label
                            >
                            <input
                                type="date"
                                class="form "
                                tabindex="2"
                                v-model="filter.dateFrom"
                            />
                        </div>
                        <div class="block w-1/4 sm:w-full md:w-1/2">
                            <label for="" class="font-semibold">Date to</label>
                            <input
                                type="date"
                                class="form"
                                tabindex="3"
                                v-model="filter.dateTo"
                            />
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            tabindex="4"
                            @click="generate()"
                            class="h-10 px-4 py-2  focus:outline-none text-white  bg-blue-500 hover:bg-blue-600 rounded"
                        >
                            Generate
                        </button>
                        <button
                            tabindex="4"
                            class="h-10 px-4 py-2 flex disabled:opacity-50  focus:outline-none text-white  bg-green-500 hover:bg-green-600 rounded"
                            @click="exportToExcel('xlsx')"
                            v-if="transactions.b_unit != null"
                            :disabled="!transactions.data.length"
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
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <span>Excel</span>
                        </button>
                        <button
                            tabindex="4"
                            class="h-10 px-4 py-2 flex disabled:opacity-50  focus:outline-none text-white  bg-green-500 hover:bg-green-600 rounded"
                            @click="printBtn"
                            v-if="transactions.b_unit != null"
                            :disabled="!transactions.data.length"
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
                            <span>Print</span>
                        </button>
                    </div>
                </div>
                <hr class="mt-2" />
                <div id="section-to-print2" class="mt-2">
                    <div v-if="transactions.b_unit != null">
                        <div class="flex justify-center items-center">
                            <center>
                                <h6 class="text-lg">
                                    {{
                                        transactions.hasOwnProperty("b_unit") &&
                                            transactions.b_unit.business_unit
                                    }}
                                </h6>
                                <p>ALTURUSH GOODS ORDERING</p>
                                <p>ACCOUNTABILITY REPORT</p>
                                <p class="text-center">
                                    {{ filter.dateFrom | formatDateNoTime }} To
                                    {{ filter.dateTo | formatDateNoTime }}
                                </p>
                            </center>
                        </div>
                        <table
                            class="min-w-full divide-y divide-gray-300 mt-5"
                            id="accountability_table"
                        >
                            <thead class="border  bg-gray-100 tracking-normal">
                                <tr class="tr">
                                    <th class="p-2 border text-left ">
                                        Cashier
                                    </th>
                                    <th class="p-2 border text-center">
                                        Ticket #
                                    </th>
                                    <th class="p-2 border text-right">
                                        Transaction #
                                    </th>
                                    <th class="p-2 text-right">Net Amount</th>
                                </tr>
                            </thead>
                            <tbody class="tbody text-center">
                                <tr v-if="!transactions.data.length">
                                    <td colspan="4" class="text-center td">
                                        NO DATA AVAILABLE
                                    </td>
                                </tr>
                                <tr
                                    v-for="(trans, i) in transactions.data"
                                    :key="i"
                                    class="tr"
                                >
                                    <td class="td text-left">
                                        {{ trans.cashier_monitoring[0].name }}
                                    </td>
                                    <td class="td text-center">
                                        {{ trans.ticket }}
                                    </td>
                                    <td class="td text-right">
                                        {{ trans.receipt }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(totalAmount(trans))
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                    class="tr"
                                >
                                    <td colspan="5" class="text-center td">
                                        <span class="font-semibold"
                                            >SUMMARY</span
                                        >
                                    </td>
                                </tr>
                                <tr
                                    class="tr"
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                >
                                    <td class="td" colspan="3">
                                        <span class="font-semibold"
                                            >SUB TOTAL :</span
                                        >
                                    </td>
                                    <td
                                        class="font-semibold td text-right"
                                    >
                                        {{
                                            orderSummary.lessDiscount
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    class="tr"
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                >
                                    <td class=" td font-semibold " colspan="3">
                                        TOTAL PICKING CHARGE :
                                    </td>
                                    <td
                                        class="td font-semibold text-right"
                                    >
                                        {{
                                            orderSummary.pickupCharge
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                >
                                    <td class="td font-semibold" colspan="3">
                                        GRAND TOTAL :
                                    </td>
                                    <td
                                        class="font-semibold td text-right"
                                    >
                                        {{
                                            orderSummary.grandTotal | toCurrency
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import Report from "../../../services/Report";

export default {
    name: "Accountability",
    data() {
        let routes = [
            {
                label: "Item ",
                route: "/reports"
            },
            {
                label: "Liquidation ",
                route: "/liquidition"
            },
            {
                label: "Accountability ",
                route: "/accountability"
            },
            {
                label: "Total Order - REMITTED",
                route: "/transaction"
            },
            {
                label: "Special Instruction, Comments & Suggestions",
                route: "/special_instruction_comments_suggestions"
            }
        ];
        return {
            routes: routes,
            transactions: [],
            stores: [],
            logo: null,
            dateNow: null,
            filter: {
                dateFrom: null,
                dateTo: null,
                store: ""
            }
        };
    },
    computed: {
        ...mapState(["errors", "Stores"]),
        orderSummary() {
            let grandTotal = 0,
                pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0;

            this.transactions.data.forEach(transaction => {
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
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS"]),
        exportToExcel(type, fn, dl) {
            const xlsName =
                "ACCOUNTABILITY-" +
                this.transactions.b_unit.business_unit +
                "-from-" +
                this.filter.dateFrom +
                "-to-" +
                this.filter.dateTo +
                ".";
            const elt = document.getElementById("accountability_table");
            const wb = XLSX.utils.table_to_book(elt, { sheet: "ACCOUNTABILITY" });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        printBtn() {
            window.print();
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

            // total = orderedAmount - discountAmount + pickingCharge
            total = orderedAmount - discountAmount;
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

            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );

            lessDiscount = orderedAmount - discountAmount;

            return lessDiscount;
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
        discountAmount(orders) {
            let discountAmount = 0;
            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );
            return discountAmount;
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
                Report.accountability_report(filter)
                    .then(res => {
                        this.transactions = res.data;
                        this.errors.store = "";
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.SET_ERRORS(error.response.data.errors);
                            setTimeout(() => {
                                this.CLEAR_ERRORS();
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
