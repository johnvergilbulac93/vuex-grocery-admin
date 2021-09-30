<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class=" text-gray-800">
            <div class="bg-gray-50 shadow-lg p-2 rounded ">
                
                <div class="mb-2 bg-gray-100 p-2">
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
                            v-if="Transactions.b_unit != null"
                            :disabled="!Transactions.data.length"
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
                            v-if="Transactions.b_unit != null"
                            :disabled="!Transactions.data.length"
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

                <div class="mt-2" id="print_this" v-if="Transactions.b_unit != null">
                    <h2
                        v-if="!Transactions.data.length"
                        class="flex justify-center items-center text-lg"
                    >
                        NO DATA AVAILABLE
                    </h2>

                    <DetailedTransactions
                        v-if="filter.type === 'DETAILED'"
                        :filter="filter"
                        :transaction="Transactions"
                    />
                    <SummaryTransactions
                        v-if="filter.type === 'SUMMARY'"
                        :filter="filter"
                        :transaction="Transactions"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DetailedTransactions from "./DetailedTransactionReport.vue";
import SummaryTransactions from "./SummaryTransactionReport.vue";
import { mapActions, mapGetters, mapMutations, mapState } from "vuex";
export default {
    name: "Transactions",
    components: { DetailedTransactions, SummaryTransactions },
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
            loading: false,
            filter: {
                dateFrom: null,
                dateNow: null,
                dateTo: null,
                store: "",
                type: ""
            }
        };
    },
    computed: {
        ...mapState(["errors", "Stores", "Transactions"]),
        ...mapGetters(["orderSummary"])
    },
    methods: {
        ...mapActions(["getStore", "getTransaction"]),
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS", "CLEAR_TRANSACTIONS"]),
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
                    this.Transactions.b_unit.business_unit +
                    "-from-" +
                    this.filter.dateFrom +
                    "-to-" +
                    this.filter.dateTo +
                    ".";
            }

            const elt = document.getElementById("transactions");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: this.filter.type
            });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        clearData() {
            this.CLEAR_TRANSACTIONS();
        },
        printBtn() {
            if (this.Transactions.data == null) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                window.print();
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
                return;
            } else {
                this.getTransaction({ filter });
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
        this.filter.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    },
    destroyed(){
        this.CLEAR_TRANSACTIONS()
    }
};
</script>
