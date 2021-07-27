<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class="container text-gray-800">
            <div class="h-96 bg-gray-50 shadow-lg p-5 rounded">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class="tracking-wider text-lg "
                        >Item Report</label
                    >
                </div>
                <div class="flex justify-center item ">
                    <div
                        class="sm:w-full md:w-1/2 lg:w-1/4 p-5 space-y-5 border"
                    >
                        <div class="w-full">
                            <select
                                class="form-input  w-full "
                                tabindex="1"
                                v-model="filter.store"
                                @change="changestore"
                            >
                                <option value="">Choose Store</option>
                                <option
                                    :value="store.bunit_code"
                                    v-for="(store, i) in Stores"
                                    :key="i"
                                >
                                    {{ store.business_unit }}
                                </option>
                            </select>
                            <p
                                class="text-red-500 text-center text-sm block"
                                v-if="errors.store"
                            >
                                <small>{{ errors.store[0] }}</small>
                            </p>
                        </div>
                        <div class="w-full">
                            <select
                                class="form-input w-full  "
                                v-model="filter.type"
                                tabindex="2"
                                @change="changestore"
                            >
                                <option value="">Choose Filter</option>
                                <option value="all">All Items</option>
                                <option value="available"
                                    >Available Items</option
                                >
                                <option value="unavailable"
                                    >Unavailable Items</option
                                >
                            </select>
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.type"
                            >
                                <small>{{ errors.type[0] }}</small>
                            </p>
                        </div>
                        <div class="w-full">
                            <button
                                class="w-full px-4 py-2 h-10 bg-blue-500 focus:outline-none hover:bg-blue-600 text-white transition duration-500 rounded"
                                @click="generate"
                            >
                                {{ loading ? "Loading..." : "Generate" }}
                            </button>
                        </div>
                        <div class="w-full">
                            <export-excel
                                class="w-full  px-4 py-2 h-10 text-center cursor-pointer bg-green-500 focus:outline-none hover:bg-green-600 text-white  transition duration-500 rounded"
                                :data="results"
                                :fields="json_fields"
                                type="xls"
                                :worksheet="filter.type"
                                :name="filename"
                                v-if="results.length"
                            >
                                Download Excel
                            </export-excel>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="fixed top-0 left-0 flex justify-center items-center w-full min-h-screen bg-white"
                v-if="loading"
            >
                <HalfCircleSpinner
                    :animation-duration="1000"
                    :size="60"
                    color="#ff1d5e"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import { HalfCircleSpinner } from "epic-spinners";
import Report from "../../../services/Report";
import Breadcrumb from "./../../../Usable/Breadcrumb";

export default {
    name: "Reports",
    components: { HalfCircleSpinner, Breadcrumb },
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
            loading: false,
            results: [],
            filename: "",
            filter: {
                type: "",
                store: ""
            },
            json_fields: {
                CODE: "itemcode",
                DESCRIPTION: "product_name",
                "CATEGORY NO": "category_no",
                "CATEGORY NAME": "category_name",
                UOM: "UOM",
                "RETAIL PRICE": "price_with_vat"
            },
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8"
                    }
                ]
            ]
        };
    },
    computed: {
        ...mapState(["Stores", "errors"])
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapMutations(["SET_ERRORS"]),
        changestore() {
            this.results = [];
        },
        generate() {
            this.loading = true;
            let filter = {
                store: this.filter.store,
                type: this.filter.type
            };
            Report.show_item_store(filter)
                .then(res => {
                    this.loading = false;
                    this.results = res.data.items;
                    this.filename = res.data.filename;
                    this.errors.type = "";
                    this.errors.store = "";
                    swal.fire(
                        "Success",
                        "Download your excel file now, by clicking the Download Excel button.",
                        "info"
                    );
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                    }
                });
        }
    },
    mounted() {
        this.getStore();
    }
};
</script>
