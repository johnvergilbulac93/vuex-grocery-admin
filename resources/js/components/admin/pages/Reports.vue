<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Reports" />
        <div class=" text-gray-800">
            <div class="h-96 bg-gray-50 shadow-lg p-2 rounded">
                <div class="mb-2 bg-gray-100 p-2">
                    <label for="" class="font-semibold text-lg "
                        >Item Report</label
                    >
                </div>
                <div class="flex justify-center item ">
                    <div
                        class="sm:w-full md:w-1/2 lg:w-1/4 p-5 space-y-5 border"
                    >
                        <div class="w-full">
                            <select
                                class="form"
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
                        <div class="w-full">
                            <select
                                class="form "
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
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import Report from "../../../services/Report";

export default {
    name: "Reports",
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
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS"]),
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
                        setTimeout(() => {
                            this.CLEAR_ERRORS();
                        }, 5000);
                    }
                });
        }
    },
    mounted() {
        this.getStore();
    }
};
</script>
