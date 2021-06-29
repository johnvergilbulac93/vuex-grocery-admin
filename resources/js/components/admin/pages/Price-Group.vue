<template>
    <div class="container text-black">
        <div class=" bg-gray-50 shadow-lg p-5 rounded  ">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-lg tracking-wider"
                    >Price Group</label
                >
            </div>
            <div
                class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2"
            >
                <div class="p-2 space-y-4 ">
                    <div class="w-full space-y-1">
                        <label for="store">Store</label>
                        <select
                            v-model="store"
                            v-bind:class="{
                                'border-red-600': errors.store
                            }"
                            tabindex="1"
                            class="w-full  px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                        >
                            <option value="">Choose Store</option>
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
                        <label for="store">Price Group</label>
                        <select
                            v-model="price_group"
                            v-bind:class="{
                                'border-red-600': errors.store
                            }"
                            tabindex="1"
                            class="w-full  px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                        >
                            <option value="">Choose Price Group</option>
                            <option
                                :value="pGroup.price_group_code"
                                v-for="pGroup in PriceGroup"
                                :key="pGroup.id"
                                >{{ pGroup.price_group_name }}
                            </option>
                        </select>
                        <p
                            class="text-red-500 text-center text-sm"
                            v-if="errors.price_group"
                        >
                            <small>{{ errors.price_group[0] }}</small>
                        </p>
                    </div>

                    <div class="w-full mt-8 flex space-x-2">
                        <button
                            @click="save"
                            tabindex="4"
                            class="w-1/2 bg-yellow-500 py-2 px-4 text-white  hover:bg-yellow-600 transition duration-500 focus:outline-none rounded"
                        >
                            Save
                        </button>
                        <button
                            @click="reset"
                            tabindex="5"
                            class="w-1/2 bg-gray-500  py-2 px-4 text-white  hover:bg-gray-600 transition duration-500 focus:outline-none rounded"
                        >
                            Clear
                        </button>
                    </div>
                </div>
                <div class=" col-span-2 p-2">
                    <div
                        class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                    >
                        <div class=" md:w-1/2 sm:w-full flex">
                            <div
                                class="relative w-1/2 border overflow-hidden flex rounded-l-lg"
                            >
                                <input
                                    type="text"
                                    class="relative py-2 px-4 pr-10 w-full   placeholder-gray-400 focus:outline-none "
                                    placeholder="Search...."
                                    v-model="tableData.search"
                                    @keyup.enter="fetch()"
                                />
                                <button
                                    @click="clear"
                                    v-if="tableData.search.length"
                                    class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-700 hover:text-red-500"
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
                                @click="fetch()"
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
                                class="py-2 px-4 focus:outline-none cursor-pointer border rounded-lg  "
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
                            <span >Entries</span>
                        </div>
                    </div>
                    <Datatable
                        :columns="columns"
                        :sortKey="sortKey"
                        :sortOrders="sortOrders"
                        @sort="sortBy"
                    >
                        <tbody class="tbody text-center">
                            <tr class="tr" v-if="!StorePriceGroup.length">
                                <td colspan="4" class="td ">
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr
                                class="tr"
                                v-for="(data, i) in StorePriceGroup"
                                :key="i"
                            >
                                <a @click="editInfo(data)"
                                    ><td class="td">
                                        {{ data.business_unit }}
                                    </td></a
                                >
                                <td class="td">{{ data.price_group_name }}</td>
                            </tr>
                        </tbody>
                    </Datatable>
                    <div class="border-t ">
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm  "
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
                                        class="h-5 w-5"
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
                                        class="h-5 w-5"
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

export default {
    name: "Price-Group",
    components: {
        Datatable
    },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "20%", label: "Store", name: "store" },
            { width: "20%", label: "Price Group", name: "price_group_code" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            id: "",
            store: "",
            price_group: "",
            columns: columns,
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
            "Stores",
            "errors",
            "PriceGroup",
            "perPage",
            "pagination",
            "StorePriceGroup"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "getPriceGroup",
            "getStorePriceGroup",
            "saveStorePriceGroup"
        ]),
        editInfo(data) {
            (this.id = data.bunit_code),
                (this.store = data.bunit_code),
                (this.price_group = data.price_group_code);
            (this.errors.store = ""), (this.errors.price_group = "");
        },
        remove() {},
        save() {
            let storepricegroup = {
                id: this.id,
                store: this.store,
                price_group: this.price_group
            };
            this.saveStorePriceGroup({
                storepricegroup: storepricegroup
            });
        },
        reset() {
            (this.id = ""),
                (this.store = ""),
                (this.price_group = ""),
                (this.errors.store = ""),
                (this.errors.price_group = "");
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getStorePriceGroup({
                currentPage: this.currentPage,
                filterData: filterData
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
        Fire.$on("reload_price_group", () => {
            this.fetch();
        });
        this.fetch();
        this.getStore();
        this.getPriceGroup();
    }
};
</script>

<style></style>
