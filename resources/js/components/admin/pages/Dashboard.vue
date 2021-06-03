<template>
    <div class="bg-gray-50 shadow-lg p-5 rounded">
        <div class="grid grid-flow-col grid-cols-4 grid-rows-1 gap-4">
            <div
                class="bg-gray-100 h-40 flex flex-col justify-between items-center w-full rounded border shadow-lg"
            >
                <div class="mt-3">
                    <h3
                        class="text-6xl text-gray-500 text-center font-semibold"
                    >
                        {{ TotalItemNotAvailable }}
                    </h3>
                    <p class="mt-2">Items not available</p>
                </div>
                <a
                    @click="viewItem"
                    class="bg-yellow-500 text-center py-2 text-white w-full hover:text-white hover:bg-yellow-600 transition duration-500    "
                >
                    <span class="">More info</span>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>

            <div
                v-if="$root.userType == 15"
                class="bg-gray-100 h-40 flex flex-col justify-between items-center w-full rounded border shadow-lg"
            >
                <div class="mt-3">
                    <h3
                        class="text-6xl text-gray-500 text-center font-semibold"
                    >
                        {{ priceCount }}
                    </h3>
                    <p class="mt-2">Price Changes</p>
                </div>
                <a
                    @click="toChangePrice"
                    class="bg-yellow-500 text-center py-2 text-white w-full hover:text-white hover:bg-yellow-600 transition duration-500    "
                >
                    <span class="">Click here to view details</span>
                </a>
            </div>

            <transition
                enter-active-class="ease-out duration-700"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-300"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="isModal"
                    class="bg-black bg-opacity-30 fixed top-10 left-0 flex justify-center items-center shadow-xl p-20 w-full min-h-screen "
                >
                    <div class="bg-white h-96 w-full  overflow-y-scroll ">
                        <div
                            class="border-b-2 p-1 flex justify-between items-center"
                        >
                            <span
                                class="tracking-tight text-gray-500 text-lg font-semibold"
                                >Item's not available</span
                            >
                            <button
                                class="focus:outline-none p-1"
                                @click="closeModal"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-gray-500 hover:text-red-500"
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
                        <div class="p-2">
                            <div
                                class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                            >
                                <div
                                    class="font-sans text-gray-600 md:w-1/2 sm:w-full flex"
                                >
                                    <div
                                        class="relative border overflow-hidden flex rounded-l-lg"
                                    >
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
                            </div>
                            <Datatable
                                :columns="columns"
                                :sortKey="sortKey"
                                :sortOrders="sortOrders"
                                @sort="sortBy"
                            >
                                <tbody class="tbody text-center">
                                    <tr
                                        class="tr"
                                        v-if="!ItemsNotAvailable.length"
                                    >
                                        <td
                                            colspan="7"
                                            class="td font-semibold"
                                        >
                                            NO DATA AVAILABLE
                                        </td>
                                    </tr>
                                    <tr
                                        class="tr"
                                        v-for="(data, i) in ItemsNotAvailable"
                                        :key="i"
                                    >
                                        <td class="td">{{ data.itemcode }}</td>
                                        <td class="td">
                                            {{ data.product_name }}
                                        </td>
                                        <td class="td">
                                            {{ data.category_name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </Datatable>
                            <div class="border-t ">
                                <div
                                    class="flex justify-between items-center mt-2"
                                >
                                    <span class="text-sm  text-gray-600"
                                        >Showing
                                        {{
                                            !pagination.from
                                                ? 0
                                                : pagination.from
                                        }}
                                        to
                                        {{ !pagination.to ? 0 : pagination.to }}
                                        of {{ pagination.total }} entries</span
                                    >
                                    <div class="flex flex-row space-x-1">
                                        <button
                                            :disabled="!pagination.prevPageUrl"
                                            @click="
                                                previousPage(
                                                    pagination.prevPageUrl
                                                )
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
                                            @click="
                                                nextPage(pagination.nextPageUrl)
                                            "
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
            </transition>
        </div>
    </div>
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState } from "vuex";
export default {
    components: { Datatable },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "70%", label: "Code", name: "itemcode" },
            { width: "20%", label: "Description", name: "product_name" },
            { width: "20%", label: "Category Name", name: "category_name" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            items: {},
            countItems: "",
            loading: true,
            priceCount: "",
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
        ...mapState([
            "isModal",
            "TotalItemNotAvailable",
            "ItemsNotAvailable",
            "perPage",
            "pagination"
        ])
    },
    methods: {
        ...mapActions(["modal", "getItemNotAvailable"]),
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
        viewItem() {
            this.modal({
                flag: true
            });
        },
        closeModal() {
            this.modal({
                flag: false
            });
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getItemNotAvailable({
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
        },
        getPriceChanges() {
            axios.get("api/count/price_changes").then(res => {
                this.priceCount = res.data;
            });
        },
        toChangePrice() {
            let url = process.env.MIX_URL_PRICE_CHANGES + btoa(this.$root.id);
            window.open(url);
        }
    },
    mounted() {
        this.fetch();
        this.getPriceChanges();
    }
};
</script>
