<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class="container text-gray-800">
            <div class="bg-gray-50 shadow-lg p-5 rounded ">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class="font-semibold text-lg "
                        >Total Order Report - REMITTED</label
                    >
                </div>
                <div
                    class="flex sm:flex-col sm:space-y-5 md:space-y-0 md:flex-row justify-between items-center"
                >
                    <div
                        class=" w-3/4 flex sm:flex-col lg:flex-row sm:space-x-0 sm:space-y-5 lg:space-x-5 lg:space-y-0 space-x-5"
                    >
                        <div class="block w-1/4 sm:w-full md:w-1/2">
                            <label for="" class="font-semibold"
                                >Report Type</label
                            >
                            <select
                                class="form "
                                v-model="filter.type"
                                @change="clearData"
                            >
                                <option value="">Select Report Type</option>
                                <option value="DETAILED">DETAILED</option>
                                <option value="SUMMARY">SUMMARY</option>
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
                                    :message="errors.type[0]"
                                    v-if="errors.type"
                                />
                            </transition>
                        </div>
                        <div class="block w-1/4 sm:w-full md:w-1/2">
                            <label for="" class="font-semibold">Store</label>
                            <select
                                class="form"
                                v-model="filter.store"
                                tabindex="1"
                                @change="clearData"
                            >
                                <option value="">Choose Store</option>
                                <option value="all">ALL STORE</option>
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
                            <transition
                                enter-active-class="ease-in duration-300"
                                enter-class="opacity-0 "
                                enter-to-class="opacity-100"
                                leave-active-class="ease-out duration-500"
                                leave-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <Error
                                    :message="errors.startDate[0]"
                                    v-if="errors.startDate"
                                />
                            </transition>
                        </div>
                        <div class="block w-1/4 sm:w-full md:w-1/2">
                            <label for="" class="font-semibold">Date to</label>
                            <input
                                type="date"
                                class="form "
                                tabindex="3"
                                v-model="filter.dateTo"
                            />
                            <transition
                                enter-active-class="ease-in duration-300"
                                enter-class="opacity-0 "
                                enter-to-class="opacity-100"
                                leave-active-class="ease-out duration-500"
                                leave-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <Error
                                    :message="errors.endDate[0]"
                                    v-if="errors.endDate"
                                />
                            </transition>
                        </div>
                    </div>
                    <div class="flex justify-end items-center space-x-2">
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
                            v-if="ArrDataStore.b_unit != null"
                            :disabled="orderSummary.gTotalTransaction == 0"
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
                            v-if="ArrDataStore.b_unit != null"
                            :disabled="orderSummary.gTotalTransaction == 0"
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

                <div class="mt-2" id="section-to-print3">
                    <div class="container" v-if="filter.type === 'DETAILED'">
                        <div
                            class="container"
                            v-if="ArrDataStore.b_unit != null"
                        >
                            <div
                                class="flex flex-col "
                                v-if="filter.store != 'all'"
                            >
                                <div class="container" id="transaction_header">
                                    <center>
                                        <h6 class="text-lg">
                                            {{
                                                ArrDataStore.hasOwnProperty(
                                                    "b_unit"
                                                ) &&
                                                    ArrDataStore.b_unit
                                                        .business_unit
                                            }}
                                        </h6>
                                        <p>
                                            ALTURUSH GOODS ORDERING
                                        </p>
                                        <p>
                                            TOTAL ORDERS REPORT(<span
                                                class="text-red-500"
                                                >{{ filter.type }}</span
                                            >)
                                        </p>
                                        <p class="text-center">
                                            {{
                                                filter.dateFrom
                                                    | formatDateNoTime
                                            }}
                                            To
                                            {{
                                                filter.dateTo | formatDateNoTime
                                            }}
                                        </p>
                                    </center>
                                </div>
                                <div class="container mt-5 " id="transactions">
                                    <table
                                        class="min-w-full divide-y divide-gray-300 mb-10"
                                        v-for="(byMonth,
                                        i) in get_results_by_month"
                                        :key="i"
                                        id="transaction_body"
                                    >
                                        <thead
                                            class="border bg-gray-100  tracking-normal"
                                        >
                                            <tr class="tr ">
                                                <th
                                                    class="p-2 border text-center"
                                                >
                                                    Date
                                                </th>
                                                <th
                                                    class="p-2 border text-left"
                                                >
                                                    Customer
                                                </th>
                                                <th
                                                    class="p-2 border text-center"
                                                >
                                                    Transaction #
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Gross Amount
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Pick-up Charge
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Total Amount
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr
                                                v-if="!byMonth.length"
                                                class="tr"
                                            >
                                                <td colspan="6" class="td">
                                                    NO DATA AVAILABLE
                                                </td>
                                            </tr>
                                            <tr
                                                v-for="(trans,
                                                innerIndex) in byMonth"
                                                :key="innerIndex"
                                                class="tr"
                                            >
                                                <td class="td text-center">
                                                    {{
                                                        trans.order_pickup
                                                            | formatDateNoTime
                                                    }}
                                                </td>
                                                <td class="td">
                                                    {{ trans.customer }}
                                                </td>
                                                <td class="td text-center">
                                                    {{ trans.receipt }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderedAmount(trans)
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        parseFloat(
                                                            trans
                                                                .customer_bill[0]
                                                                .picking_charge
                                                        ) | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        parseFloat(
                                                            totalAmount(trans)
                                                        ) | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                            <tr
                                                v-if="
                                                    ArrDataStore.hasOwnProperty(
                                                        'data'
                                                    ) &&
                                                        ArrDataStore.data.length
                                                "
                                                class="tr"
                                            >
                                                <td
                                                    colspan="2"
                                                    class="td font-semibold"
                                                >
                                                    Sub Total
                                                </td>
                                                <td
                                                    class="td text-center font-semibold"
                                                >
                                                    {{ byMonth.length }}
                                                </td>
                                                <td
                                                    class="td text-right font-semibold"
                                                >
                                                    {{
                                                        totalOrderAmount(
                                                            byMonth
                                                        ).orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td
                                                    class="td text-right font-semibold"
                                                >
                                                    {{
                                                        totalOrderAmount(
                                                            byMonth
                                                        ).pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td
                                                    class="td text-right font-semibold"
                                                >
                                                    {{
                                                        totalOrderAmount(
                                                            byMonth
                                                        ).grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="transaction_footer">
                                        <table
                                            id="transaction_body"
                                            class="min-w-full divide-y divide-gray-300 "
                                            v-if="
                                                orderSummary.gTotalTransaction !=
                                                    0
                                            "
                                        >
                                            <thead
                                                class="border  bg-gray-100  tracking-wide font-poppins"
                                            >
                                                <tr class="tr">
                                                    <th
                                                        colspan="2"
                                                        class="p-2"
                                                    ></th>
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
                                                    <td
                                                        colspan="2"
                                                        class="td font-semibold "
                                                    >
                                                        Grand Total
                                                    </td>
                                                    <td
                                                        class="td  text-center font-semibold"
                                                    >
                                                        {{
                                                            orderSummary.gTotalTransaction
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td text-center font-semibold"
                                                    >
                                                        {{
                                                            orderSummary.orderAmount
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td text-center font-semibold"
                                                    >
                                                        {{
                                                            orderSummary.pickupCharge
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td text-center font-semibold"
                                                    >
                                                        {{
                                                            orderSummary.grandTotal
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <small
                                            class="text-xs flex justify-end mt-2"
                                            v-if="ArrDataStore.data.length"
                                            >Run Time: {{ dateNow }}</small
                                        >
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex flex-col "
                                v-else
                                id="allstore_detailed"
                            >
                                <div class="container" id="transaction_header">
                                    <center>
                                        <h6 class="text-lg">
                                            ALL STORES
                                        </h6>
                                        <p>
                                            ALTURUSH GOODS ORDERING
                                        </p>
                                        <p>
                                            TOTAL ORDERS REPORT(<span
                                                class="text-red-500"
                                                >{{ filter.type }}</span
                                            >)
                                        </p>
                                        <p class="text-center ">
                                            {{
                                                filter.dateFrom
                                                    | formatDateNoTime
                                            }}
                                            To
                                            {{
                                                filter.dateTo | formatDateNoTime
                                            }}
                                        </p>
                                    </center>
                                </div>
                                <div class="container mt-5" id="transactions">
                                    <table
                                        class="min-w-full divide-y divide-gray-300 mb-10"
                                        v-for="(store,
                                        i) in get_results_by_store"
                                        :key="i"
                                        id="transaction_body"
                                    >
                                        <thead
                                            class="border  bg-gray-100  tracking-wide font-poppins"
                                        >
                                            <tr class="tr">
                                                <th
                                                    colspan="6"
                                                    class=" p-2 border"
                                                >
                                                    <span
                                                        class="font-semibold flex justify-start"
                                                        >{{
                                                            store[0]
                                                                .business_unit
                                                        }}</span
                                                    >
                                                </th>
                                            </tr>
                                            <tr class="td">
                                                <th
                                                    class="p-2 text-center border"
                                                >
                                                    Date
                                                </th>
                                                <th
                                                    class="p-2 text-left border"
                                                >
                                                    Customer
                                                </th>
                                                <th
                                                    class="p-2 text-center border"
                                                >
                                                    Transaction #.
                                                </th>
                                                <th
                                                    class="p-2 text-right border"
                                                >
                                                    Gross Amount
                                                </th>
                                                <th
                                                    class="p-2 text-right border"
                                                >
                                                    Picking Charge
                                                </th>
                                                <th
                                                    class="p-2 text-right border"
                                                >
                                                    Total Amount
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr v-if="!store.length" class="tr">
                                                <td colspan="6" class="td">
                                                    NO DATA AVAILABLE
                                                </td>
                                            </tr>
                                            <tr
                                                v-for="(trans,
                                                innerIndex) in store"
                                                :key="innerIndex"
                                                class="tr"
                                            >
                                                <td class="td text-center">
                                                    {{
                                                        trans.order_pickup
                                                            | formatDateNoTime
                                                    }}
                                                </td>
                                                <td class="td text-left">
                                                    {{ trans.customer }}
                                                </td>
                                                <td class="td text-center">
                                                    {{ trans.receipt }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderedAmount(trans)
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        parseFloat(
                                                            trans
                                                                .customer_bill[0]
                                                                .delivery_charge
                                                        ) | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        parseFloat(
                                                            totalAmount(trans)
                                                        ) | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="tr font-semibold">
                                                <td colspan="2" class="td ">
                                                    Sub Total
                                                </td>
                                                <td class="td text-center">
                                                    {{ store.length }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="transaction_footer">
                                        <table
                                            class="min-w-full divide-y divide-gray-300"
                                            v-if="
                                                orderSummary.gTotalTransaction !=
                                                    0
                                            "
                                        >
                                            <thead
                                                class="border  bg-gray-100 tracking-normal"
                                            >
                                                <tr class="tr">
                                                    <th
                                                        colspan="2"
                                                        class="p-2 border"
                                                    ></th>
                                                    <th class="p-2 border">
                                                        Transaction #
                                                    </th>
                                                    <th
                                                        class="p-2 border text-right"
                                                    >
                                                        Gross Amount
                                                    </th>
                                                    <th
                                                        class="p-2 border text-right"
                                                    >
                                                        Picking Charge
                                                    </th>
                                                    <th
                                                        class="p-2 border text-right"
                                                    >
                                                        Total Amount
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                <tr class="tr">
                                                    <td
                                                        colspan="2"
                                                        class="td font-semibold"
                                                    >
                                                        GRAND TOTAL
                                                    </td>
                                                    <td
                                                        class="td font-semibold text-center"
                                                    >
                                                        {{
                                                            orderSummary.gTotalTransaction
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td font-semibold text-right"
                                                    >
                                                        {{
                                                            orderSummary.orderAmount
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td font-semibold text-right"
                                                    >
                                                        {{
                                                            orderSummary.pickupCharge
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td font-semibold text-right"
                                                    >
                                                        {{
                                                            orderSummary.grandTotal
                                                                | toCurrency
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <small
                                            class="text-xs flex justify-end mt-2"
                                            v-if="ArrDataStore.data.length"
                                            >Run Time: {{ dateNow }}</small
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="ArrDataStore.b_unit != null">
                            <div
                                class="flex flex-col "
                                v-if="filter.store === 'all'"
                                id="transaction_body"
                            >
                                <div class="container">
                                    <center>
                                        <h6 class="text-lg">
                                            ALL STORES
                                        </h6>
                                        <p>
                                            ALTURUSH GOODS ORDERING
                                        </p>
                                        <p>
                                            TOTAL ORDERS REPORT(<span
                                                class="text-red-500"
                                                >{{ filter.type }}</span
                                            >)
                                        </p>
                                        <p class="text-center ">
                                            {{
                                                filter.dateFrom
                                                    | formatDateNoTime
                                            }}
                                            To
                                            {{
                                                filter.dateTo | formatDateNoTime
                                            }}
                                        </p>
                                    </center>
                                </div>
                                <div>
                                    <table
                                        class="min-w-full divide-y divide-gray-300  mt-5"
                                        id="transactions"
                                    >
                                        <thead
                                            class="border bg-gray-100 tracking-normal"
                                        >
                                            <tr class="tr">
                                                <th
                                                    class="p-2 border text-left"
                                                >
                                                    STORE NAME
                                                </th>
                                                <th class="p-2 border">
                                                    Total Orders
                                                </th>

                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Gross Amount
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Picking Charge
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr
                                                v-for="(store,
                                                i) in get_results_by_store"
                                                :key="i"
                                                class="tr"
                                            >
                                                <td class="td">
                                                    {{ store[0].business_unit }}
                                                </td>
                                                <td class="td text-center">
                                                    {{ store.length }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="tr font-semibold">
                                                <td class="td">
                                                    GRAND TOTAL
                                                </td>
                                                <td class="td text-center">
                                                    {{
                                                        orderSummary.gTotalTransaction
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small
                                        class="text-xs flex justify-end mt-2"
                                        v-if="ArrDataStore.data.length"
                                        >Run Time: {{ dateNow }}</small
                                    >
                                </div>
                            </div>
                            <div class="container" v-else>
                                <div id="transaction_body">
                                    <center>
                                        <h6 class="text-lg">
                                            {{
                                                ArrDataStore.hasOwnProperty(
                                                    "b_unit"
                                                ) &&
                                                    ArrDataStore.b_unit
                                                        .business_unit
                                            }}
                                        </h6>
                                        <p>
                                            ALTURUSH GOODS ORDERING
                                        </p>
                                        <p>
                                            TOTAL ORDERS REPORT(<span
                                                class="text-red-500"
                                                >{{ filter.type }}</span
                                            >)
                                        </p>
                                        <p class="text-center ">
                                            {{
                                                filter.dateFrom
                                                    | formatDateNoTime
                                            }}
                                            To
                                            {{
                                                filter.dateTo | formatDateNoTime
                                            }}
                                        </p>
                                    </center>
                                </div>
                                <div id="transaction_body">
                                    <table
                                        class="min-w-full divide-y divide-gray-300 mt-5"
                                        id="transactions"
                                    >
                                        <thead
                                            class="border bg-gray-100  tracking-normal"
                                        >
                                            <tr class="tr">
                                                <th
                                                    class="p-2 border text-left"
                                                >
                                                    Date
                                                </th>
                                                <th class="p-2 border ">
                                                    Total Order
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Gross Amount
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Picking Charge
                                                </th>
                                                <th
                                                    class="p-2 border text-right"
                                                >
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr
                                                v-for="(store,
                                                i) in get_results_by_month"
                                                :key="i"
                                                class="tr"
                                            >
                                                <td class="td ">
                                                    {{
                                                        store[0].order_pickup
                                                            | formatDateMonthOnly
                                                    }}
                                                </td>
                                                <td class="td text-center">
                                                    {{ store.length }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        totalOrderAmount(store)
                                                            .grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="tr font-semibold">
                                                <td class="td">
                                                    GRAND TOTAL
                                                </td>
                                                <td class="td text-center">
                                                    {{
                                                        orderSummary.gTotalTransaction
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.orderAmount
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.pickupCharge
                                                            | toCurrency
                                                    }}
                                                </td>
                                                <td class="td text-right">
                                                    {{
                                                        orderSummary.grandTotal
                                                            | toCurrency
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small
                                        class="text-xs flex justify-end mt-2"
                                        v-if="ArrDataStore.data.length"
                                        >Run Time: {{ dateNow }}</small
                                    >
                                </div>
                            </div>
                        </div>
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
    name: "Transactions",
    created() {},
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
            ArrDataStore: [],
            stores: [],
            dateNow: null,
            loading: false,
            filter: {
                dateFrom: null,
                dateTo: null,
                store: "",
                type: ""
            }
        };
    },
    computed: {
        ...mapState(["errors", "Stores"]),
        get_results_by_store() {
            return _.groupBy(this.ArrDataStore.data, "acroname");
        },
        get_results_by_month() {
            const ArrResultsByMonth = this.ArrDataStore.data;
            const newData = _.groupBy(ArrResultsByMonth, function(d) {
                return moment(d.order_pickup).month();
            });
            return newData;
        },
        orderSummary() {
            let grandTotal = 0,
                pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                gTotalTransaction = this.ArrDataStore.data.length;

            this.ArrDataStore.data.forEach(transaction => {
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
                lessDiscount,
                gTotalTransaction
            };
        }
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS"]),
        exportToExcel(type, fn, dl) {
            let xlsName = "";

            if (this.filter.store === "all") {
                xlsName =
                    "ALL-STORE" +
                    "-from-" +
                    this.filter.dateFrom +
                    "-to-" +
                    this.filter.dateTo +
                    ".";
            } else {
                xlsName =
                    "TRANSACTIONS-" +
                    this.ArrDataStore.b_unit.business_unit +
                    "-from-" +
                    this.filter.dateFrom +
                    "-to-" +
                    this.filter.dateTo +
                    ".";
            }

            const elt = document.getElementById("transactions");
            const wb = XLSX.utils.table_to_book(elt, { sheet: this.filter.type });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        clearData() {
            this.ArrDataStore = [];
        },
        printBtn() {
            if (this.ArrDataStore.data == null) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                window.print();
            }
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
        },
        generate() {
            let filter = {
                store: this.filter.store,
                startDate: this.filter.dateFrom,
                endDate: this.filter.dateTo,
                type: this.filter.type
            };
            if (this.filter.dateFrom > this.filter.dateTo) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                Report.total_orders_report(filter)
                    .then(res => {
                        this.ArrDataStore = res.data;
                        this.errors.store = "";
                        this.errors.type = "";
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
