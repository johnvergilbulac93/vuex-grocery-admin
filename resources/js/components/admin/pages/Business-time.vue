<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Setup" />
        <div class="container bg-gray-50 shadow-lg p-5 rounded text-gray-800 ">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="tracking-wider text-lg ">Store Time</label>
            </div>
            <div
                class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2"
            >
                <div class="p-2 tracking-normal">
                    <div class="flex flex-col space-y-2">
                        <div class="w-full space-y-1">
                            <label for="store" class="font-semibold"
                                >Store</label
                            >
                            <select
                                v-model="store"
                                v-bind:class="{
                                    'border-red-600': errors.store
                                }"
                                tabindex="1"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            >
                                <option value="">Select Store</option>
                                <option
                                    :value="store.bunit_code"
                                    v-for="store in Stores"
                                    :key="store.bunit_code"
                                    >{{ store.business_unit }}
                                </option>
                            </select>
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.store"
                            >
                                <small>{{ errors.store[0] }}</small>
                            </p>
                        </div>

                        <div class="w-full space-y-1">
                            <label for="start" class="font-semibold"
                                >Start</label
                            >
                            <input
                                tabindex="2"
                                type="time"
                                v-model="opening_time"
                                v-bind:class="{
                                    'border-red-600': errors.opening_time
                                }"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.opening_time"
                            >
                                <small>{{ errors.opening_time[0] }}</small>
                            </p>
                        </div>
                        <div class="w-full space-y-1">
                            <label for="end" class="font-semibold">End</label>
                            <input
                                tabindex="3"
                                type="time"
                                v-bind:class="{
                                    'border-red-600': errors.closing_time
                                }"
                                v-model="closing_time"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.closing_time"
                            >
                                <small>{{ errors.closing_time[0] }}</small>
                            </p>
                        </div>
                    </div>

                    <div class="w-full mt-8 flex space-x-2">
                        <button
                            @click="save"
                            tabindex="4"
                            class="w-1/2 bg-blue-500 py-2 px-4 text-white text-sm hover:bg-blue-600 transition duration-500 focus:outline-none rounded"
                        >
                            Save
                        </button>
                        <button
                            @click="reset"
                            tabindex="5"
                            class="w-1/2 bg-gray-500  py-2 px-4 text-white text-sm  hover:bg-gray-600 transition duration-500 focus:outline-none rounded"
                        >
                            Clear
                        </button>
                    </div>
                </div>
                <div class="col-span-2">
                    <div
                        class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                    >
                        <div class="md:w-1/2 sm:w-full flex">
                            <div
                                class="relative w-1/2 border overflow-hidden flex rounded-l-lg"
                            >
                                <input
                                    type="text"
                                    class="relative py-2 px-4 pr-10 w-full outline-none  focus:outline-none "
                                    placeholder="Search...."
                                    v-model="tableData.search"
                                    @keyup.enter="search"
                                />
                                <button
                                    @click="clear"
                                    v-if="tableData.search.length"
                                    class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  text-center flex items-center justify-center focus:outline-none "
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 hover:text-red-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <button
                                @click="search"
                                class="py-2 px-4 border-r border-t border-b border-gray-200 focus:outline-none hover:bg-yellow-500 hover:text-white rounded-r-lg"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 "
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div class="text-sm">
                            <span>Show</span>
                            <select
                                class="py-2 px-4 focus:outline-none cursor-pointer border rounded-lg"
                                v-model="tableData.length"
                                @change="fetch()"
                            >
                                <option
                                    v-for="(records, index) in perPage"
                                    :key="index"
                                    :value="records"
                                >
                                    {{ records }}
                                </option>
                            </select>
                            <span>Entries</span>
                        </div>
                    </div>
                    <Datatable
                        :columns="columns"
                        :sortKey="sortKey"
                        :sortOrders="sortOrders"
                        @sort="sortBy"
                    >
                        <tbody class="tbody">
                            <tr class="tr" v-if="!StoreHourList.length">
                                <td colspan="5" class="td text-center">
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr
                                class="tr"
                                v-for="(data, i) in StoreHourList"
                                :key="i"
                            >
                                <a
                                    @click="editInfo(data)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Edit"
                                    ><td class="td">
                                        {{ data.business_unit }}
                                    </td></a
                                >
                                <td class="td text-center">
                                    {{ data.time_in }}
                                </td>
                                <td class="td text-center">
                                    {{ data.time_out }}
                                </td>
                                <td
                                    class="td text-center"
                                    v-if="data.status == 1"
                                >
                                    <a @click="statusActive(data)">
                                        <span
                                            class="bg-green-400 px-2 py-1 rounded-full text-gray-50  text-xs hover:bg-green-500 hover:text-white transition duration-500"
                                        >
                                            Active</span
                                        >
                                    </a>
                                </td>
                                <td class="text-center" v-else>
                                    <a @click="statusInActive(data)">
                                        <span
                                            class="bg-red-500 px-2 py-1 rounded-full text-gray-50 font-semibold text-xs hover:bg-red-600 hover:text-white transition duration-500"
                                        >
                                            Inactive</span
                                        >
                                    </a>
                                </td>
                                <td class="td text-center">
                                    <button
                                        class="p-1 focus:outline-none"
                                        @click="remove(data.id)"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Delete"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-700 hover:text-red-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        class="p-1 focus:outline-none"
                                        @click="editInfo(data)"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Edit"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-700 hover:text-green-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                            />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </Datatable>
                    <div class="border-t ">
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm"
                                >Showing
                                {{ !pagination.from ? 0 : pagination.from }} to
                                {{ !pagination.to ? 0 : pagination.to }} of
                                {{ pagination.total }} entries</span
                            >
                            <div class="flex flex-row space-x-1">
                                <button
                                    :disabled="!pagination.prevPageUrl"
                                    @click="
                                        previousPage(pagination.prevPageUrl)
                                    "
                                    class="footer-btn flex items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 19l-7-7 7-7"
                                        /></svg
                                    >Prev
                                </button>
                                <button
                                    :disabled="!pagination.nextPageUrl"
                                    @click="nextPage(pagination.nextPageUrl)"
                                    class="footer-btn flex items-center"
                                >
                                    Next
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState } from "vuex";
import Breadcrumb from "./../../../Usable/Breadcrumb";

export default {
    name: "Business-Time",
    components: {
        Datatable,
        Breadcrumb
    },
    data() {
        let sortOrders = {};
        let routes = [
            {
                label: "Business Rules",
                route: "/business_rules"
            },
            {
                label: "Store time",
                route: "/bu_time"
            },
            {
                label: "Tenant",
                route: "/tenant"
            },
            {
                label: "Delivery Charges",
                route: "/delivery_charges"
            },
            {
                label: "Minimum Order Delivery",
                route: "/minimum_delivery"
            },
            {
                label: "Manage User",
                route: "/users"
            },
            {
                label: "Price Group",
                route: "/price_group"
            }
        ];
        let columns = [
            {
                width: "70%",
                label: "Store",
                name: "description",
                class: "text-left"
            },
            {
                width: "20%",
                label: "Opening Time",
                name: "opening_time",
                class: "text-center"
            },
            {
                width: "20%",
                label: "Closing Time",
                name: "closing_time",
                class: "text-center"
            },
            {
                width: "20%",
                label: "Status",
                name: "statuss",
                class: "text-center"
            },
            {
                width: "10%",
                label: "Action",
                name: "idss",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            business_units: [],
            editMode: false,
            selectedData: false,
            id: "",
            store: "",
            opening_time: "",
            closing_time: "",
            columns: columns,
            routes: routes,
            sortKey: "deadline",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                column: 1,
                dir: "desc"
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "StoreHourList",
            "pagination",
            "Stores",
            "errors"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "showStoreHour",
            "saveStoreHour",
            "deleteStoreHour",
            "statusStoreInactive",
            "statusStoreActive"
        ]),
        statusActive(data) {
            let status = {
                id: data.id
            };
            this.statusStoreActive({ status });
        },
        statusInActive(data) {
            let status = {
                id: data.id
            };
            this.statusStoreInactive({ status });
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        editInfo(data) {
            (this.id = data.id),
                (this.store = data.bunit_code),
                (this.opening_time = data.time_in),
                (this.closing_time = data.time_out);
        },
        remove(id) {
            this.deleteStoreHour({
                id: id
            });
        },
        reset() {
            this.id = "";
            this.store = "";
            this.opening_time = "";
            this.closing_time = "";
            this.errors.store = "";
            this.errors.opening_time = "";
            this.errors.closing_time = "";
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search() {
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.showStoreHour({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        save() {
            let storehour = {
                id: this.id,
                store: this.store,
                opening_time: this.opening_time,
                closing_time: this.closing_time
            };
            this.saveStoreHour({
                storehour: storehour
            });
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.fetch();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        }
    },
    mounted() {
        Fire.$on("reload_time", () => {
            this.fetch();
            this.reset();
        });
        this.fetch();
        this.getStore();
    }
};
</script>
