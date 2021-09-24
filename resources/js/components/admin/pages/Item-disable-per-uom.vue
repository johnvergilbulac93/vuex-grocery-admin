<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="item" />
        <div class=" text-gray-800">
            <div class="bg-gray-50 shadow-lg p-2 rounded overflow-x-auto">
                <div class="mb-2 bg-gray-100 p-2">
                    <label for="" class=" text-lg font-semibold"
                        >Disable Item Unit of Measure(UOM)</label
                    >
                </div>
                <div
                    class="flex sm:flex-wrap sm:space-y-2 md:space-y-0 justify-between items-center mb-2"
                >
                    <div class=" md:w-1/2 sm:w-full flex items-center gap-0.5">
                        <div class="relative w-1/2 flex items-center">
                            <input
                                type="text"
                                class="form-search "
                                placeholder="Search...."
                                v-model="tableData.search"
                                @keyup.enter="search"
                            />
                            <button
                                @click="clear"
                                v-if="tableData.search.length"
                                class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5  hover:text-red-500"
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
                        <button @click="search" class="button-search">
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
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="w-72">
                        <select
                            class="form "
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
                    <div class="text-sm">
                        <span>Show</span>
                        <select
                            class="form-sort  "
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
                <div class="mb-1">
                    <button
                        class="flex items-center bg-red-500 px-2 py-1 focus:outline-none text-white  hover:bg-red-600 transition duration-500 rounded"
                        v-if="form.itemIds.length != 0"
                        @click="disabledAll"
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
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                            />
                        </svg>
                        Disable
                    </button>
                </div>
                <table class="min-w-full">
                    <thead class="border bg-gray-100 tracking-normal ">
                        <tr>
                            <th class="th text-center border">
                                <input
                                    type="checkbox"
                                    class="form-checkbox"
                                    @click="selectAll"
                                    v-model="allSelected"
                                />
                            </th>
                            <th
                                v-for="column in columns"
                                :key="column.name"
                                @click="sortBy(column.name)"
                                class="p-3 border"
                                :class="[
                                    sortKey === column.name
                                        ? sortOrders[column.name] > 0
                                            ? 'sorting_up'
                                            : 'sorting_down'
                                        : 'sorting_both',
                                    column.class
                                ]"
                                style="cursor:pointer;"
                            >
                                {{ column.label }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody ">
                        <tr class="tr" v-if="!Items.length">
                            <td colspan="6" class="td text-center ">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(item, i) in Items" :key="i" class="tr">
                            <td class="td text-center">
                                <input
                                    type="checkbox"
                                    class="form-checkbox"
                                    :value="item.price_id"
                                    v-model="form.itemIds"
                                    @click="select"
                                />
                            </td>
                            <td class="td ">{{ item.itemcode }}</td>
                            <td class="td">{{ item.product_name }}</td>
                            <td class="td">{{ item.category_name }}</td>
                            <td class="td text-center">{{ item.UOM }}</td>
                            <td class=" td text-center">
                                {{ item.price_with_vat | toCurrency2 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    :pagination="pagination"
                    @prev="previousPage(pagination.prevPageUrl)"
                    @next="nextPage(pagination.nextPageUrl)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Tagging-Disable-UOM",
    data() {
        let sortOrders = {};
        let routes = [
            {
                label: "Item Masterfile",
                route: "/central_item"
            },
            {
                label: "Disable Item Unit of Measure(UOM)",
                route: "/disable_uom"
            },
            {
                label: "Enable Item Unit of Measure(UOM)",
                route: "/enable_uom"
            }
        ];
        let columns = [
            {
                width: "25%",
                label: "Code",
                name: "code",
                class: "text-left"
            },
            {
                width: "25%",
                label: "Description",
                name: "description",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Category Name",
                name: "catname",
                class: "text-left"
            },
            {
                width: "15%",
                label: "UOM",
                name: "uom",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Price",
                name: "price",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            routes: routes,
            columns: columns,
            sortKey: "code",
            sortOrders: sortOrders,
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
            "getItemEnable",
            "disableItemPerUOM"
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
            this.getItemEnable({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search() {
            this.fetch();
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        disabledAll() {
            let itemCode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to  disable this item/uom?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, disable it."
            }).then(result => {
                if (result.isConfirmed) {
                    this.disableItemPerUOM({ itemCode });
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
        this.getItemCategory();
    }
};
</script>
