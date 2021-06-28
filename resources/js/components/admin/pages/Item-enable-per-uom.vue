<template>
    <div class="container">
        <div class="bg-gray-50 shadow-lg p-5 rounded overflow-x-auto">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-gray-500 text-lg font-semibold"
                    >Enable Item Unit of Measure(UOM)</label
                >
            </div>
            <div
                class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
            >
                <div class=" text-gray-600 md:w-1/2 sm:w-full flex">
                    <div
                        class="relative w-1/2 border overflow-hidden flex rounded-l-lg"
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
                <div class="text-gray-600 w-72">
                    <select
                        class="w-72 py-2 px-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 "
                        v-model="tableData.category"
                        @change="fetch()"
                    >
                        <option value="">Filter by Category</option>
                        <option
                            v-for="(category, index) in ItemCategory"
                            :key="index"
                            :value="category.category_name"
                        >
                            {{ category.category_name }}
                        </option>
                    </select>
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
            <div class="mb-1">
                <button
                    class="flex items-center bg-green-500 px-2 py-1 focus:outline-none text-white font-semibold hover:bg-green-600 transition duration-500 rounded"
                    v-if="form.itemIds.length != 0"
                    @click="enabledAll"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                        />
                    </svg>
                    Enable
                </button>
            </div>
            <table class="min-w-full divide-y divide-gray-300">
                <thead
                    class="border-t-2 border-gray-300 bg-gray-100 text-gray-500 tracking-wide font-poppins"
                >
                    <tr>
                        <th class="th">
                            <input
                                type="checkbox"
                                class="h-5 w-5 cursor-pointer focus:outline-none "
                                @click="selectAll"
                                v-model="allSelected"
                            />
                        </th>
                        <th class="th">Itemcode</th>
                        <th class="th">Description</th>
                        <th class="th">Category Name</th>
                        <th class="th">UOM</th>
                        <th class="th">Price</th>
                    </tr>
                </thead>
                <tbody class="tbody text-center">
                    <tr class="tr" v-if="!Items.length">
                        <td colspan="6" class="td font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(item, i) in Items" :key="i" class="tr">
                        <td class="td">
                            <input
                                type="checkbox"
                                class="h-5 w-5 cursor-pointer "
                                :value="item.price_id"
                                v-model="form.itemIds"
                                @click="select"
                            />
                        </td>
                        <td class="td">{{ item.itemcode }}</td>
                        <td class="td">{{ item.product_name }}</td>
                        <td class="td">{{ item.category_name }}</td>
                        <td class="td">{{ item.UOM }}</td>
                        <td class="font-semibold text-blue-500">
                            {{ item.price_with_vat }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="border-t ">
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm  text-gray-600"
                        >Showing {{ !pagination.from ? 0 : pagination.from }} to
                        {{ !pagination.to ? 0 : pagination.to }} of
                        {{ pagination.total }} entries</span
                    >
                    <div class="flex flex-row space-x-1">
                        <button
                            :disabled="!pagination.prevPageUrl"
                            @click="previousPage(pagination.prevPageUrl)"
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
</template>

<script>
import Pagination from "./Pagination.vue";
import { mapActions, mapState } from "vuex";

export default {
    components: { pagination: Pagination },
    name: "Tagging-Enable-UOM",

    data() {
        return {
            selected: [],
            allSelected: false,
            form: {
                itemIds: []
            },
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                column: 1,
                dir: "asc",
                category: ""
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState(["perPage", "pagination", "ItemCategory", "Items"])
    },
    methods: {
        ...mapActions([
            "getItemCategory",
            "getItemDisable",
            "enableItemPerUOM"
        ]),
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category
            };
            this.getItemDisable({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search() {
            this.fetch();
        },
        enabledAll() {
            let itemCode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to enable this item/uom?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, enable it."
            }).then(result => {
                if (result.isConfirmed) {
                    this.enableItemPerUOM({ itemCode });
                    setTimeout(() => {
                        this.fetch();
                    }, 1000);
                    this.form.itemIds = [];
                    this.allSelected = false;
                }
            });
        },
        selectAll() {
            this.form.itemIds = [];
            let item;
            if (!this.allSelected) {
                for (item in this.Items) {
                    this.form.itemIds.push(
                        this.Items[item].price_id.toString()
                    );
                }
            }
        },
        select() {
            this.allSelected = false;
        }
    },
    mounted() {
        this.fetch();
        this.getItemCategory();
    }
};
</script>
