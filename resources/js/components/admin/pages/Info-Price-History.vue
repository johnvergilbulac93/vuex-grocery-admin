<template>
    <div class="container p-5">
        <div
            class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
        >
            <div class=" text-gray-600 md:w-1/2 sm:w-full flex">
                <div class="relative w-1/2 border overflow-hidden flex rounded-l-lg">
                    <input
                        type="text"
                        class="relative py-2 px-4 pr-10 w-full outline-none text-gray-600 placeholder-gray-400 focus:outline-none focus:shadow-outline"
                        placeholder="Search...."
                        v-model="tableData.search"
                        @keyup.enter="search"
                    />
                    <button
                        @click="clear"
                        v-if="tableData.search.length"
                        class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center focus:outline-none "
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-500 hover:text-red-500"
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
            <div class="text-gray-600">
                <span class="text-sm text-gray-600">Show</span>
                <select
                    class="py-2 px-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 "
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
                <span class="text-sm text-gray-600">Entries</span>
            </div>
        </div>
        <Datatable
            :columns="columns"
            :sortKey="sortKey"
            :sortOrders="sortOrders"
            @sort="sortBy"
        >
            <tbody class="tbody text-center">
                <tr class="tr" v-if="!PriceChangeInfo.length">
                    <td colspan="7" class="td font-semibold tracking-wider">
                        NO DATA AVAILABLE
                    </td>
                </tr>
                <tr class="tr" v-for="(data, i) in PriceChangeInfo" :key="i">
                    <td class="td">{{ data.itemcode }}</td>
                    <td class="td">{{ data.product_name }}</td>
                    <td class="td">{{ data.UOM }}</td>
                    <td class="td">{{ data.prev_price }}</td>
                    <td class="td">{{ data.new_price }}</td>
                </tr>
            </tbody>
        </Datatable>

        <div class="border-t ">
            <div class="flex justify-between items-center mt-2">
                <span class="text-sm  text-gray-600"
                    >Showing {{ !pagination.from ? 0 : pagination.from }} to
                    {{ !pagination.to ? 0 : pagination.to }} of
                    {{ pagination.total }} entries</span
                >
                <div>
                    <button
                        :disabled="!pagination.prevPageUrl"
                        @click="previousPage(pagination.prevPageUrl)"
                        class="footer-btn"
                    >
                        <i class="fas fa-angle-double-left"></i> Prev
                    </button>
                    <button
                        :disabled="!pagination.nextPageUrl"
                        @click="nextPage(pagination.nextPageUrl)"
                        class="footer-btn"
                    >
                        Next <i class="fas fa-angle-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState } from "vuex";

export default {
    name: "Price-Changed-Today",
    components: { Datatable },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "70%", label: "Code", name: "description" },
            { width: "20%", label: "Description", name: "category" },
            { width: "20%", label: "UOM", name: "status" },
            { width: "10%", label: "Prev. Price", name: "idss" },
            { width: "10%", label: "New Price", name: "idsss" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "deadline",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                column: 1,
                dir: "asc"
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState(["perPage", "PriceChangeInfo", "pagination"])
    },
    methods: {
        ...mapActions(["getPriceChangedInfo"]),
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        search() {
            this.fetch();
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
            this.getPriceChangedInfo({
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
        this.fetch();
    }
};
</script>
