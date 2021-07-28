<template>
    <div class="container text-gray-800">
        <div class=" bg-gray-50 shadow-lg p-5 rounded">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class=" text-lg font-semibold"
                    >Item Masterfile</label
                >
            </div>
            <div
                class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
            >
                <div
                    class="   md:w-1/3 sm:w-full flex"
                >
                    <div
                        class="relative border w-64 overflow-hidden flex rounded-l-lg mt-2 "
                    >
                        <input
                            type="text"
                            class="relative py-2 px-4 pr-10 w-full focus:outline-none focus:shadow-outline "
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
                    <button
                        @click="search"
                        class="mt-2 py-2 px-4 border-r border-t border-b border-gray-200 focus:outline-none hover:bg-yellow-500 hover:text-white rounded-r-lg"
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
                <div class=" w-72">
                    <select
                        class="w-72 py-2 px-4 focus:outline-none cursor-pointer border rounded-lg "
                        v-model="tableData.category"
                        @change="fetch()"
                    >
                        <option value="">Choose Category</option>
                        <option
                            v-for="(category, index) in ItemCategory"
                            :key="index"
                            :value="category.category_name"
                        >
                            {{ category.category_name }}
                        </option>
                    </select>
                </div>
                <div class=" w-48">
                    <select
                        class="w-48 py-2 px-4 focus:outline-none cursor-pointer border rounded-lg  "
                        v-model="tableData.type"
                        @change="fetch()"
                    >
                        <option value="">Item Availability</option>
                        <option value="1">Available Item</option>
                        <option value="2">Unavailable Item</option>
                    </select>
                </div>
                <div class=" w-40">
                    <select
                        class="w-40 py-2 px-4 focus:outline-none cursor-pointer border rounded-lg  "
                        v-model="tableData.dir"
                        @change="fetch()"
                    >
                        <option value="">Sort By</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <div class="text-sm">
                    <span >Show</span>
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
            <div class="flex space-x-2">
                <div class="mb-1">
                    <button
                        class="flex items-center bg-red-500 px-2 py-1 focus:outline-none text-white  hover:bg-red-600 transition duration-500 rounded"
                        v-if="form.itemIds.length != 0"
                        @click="disableAll"
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
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                        Disable
                    </button>
                </div>
                <div class="mb-1">
                    <button
                        class="flex items-center bg-green-500 px-2 py-1 focus:outline-none text-white  hover:bg-green-600 transition duration-500 rounded"
                        v-if="form.itemIds.length != 0"
                        @click="enableAll"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        Enable
                    </button>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-300">
                <thead
                    class="border-t-2 border-gray-300 bg-gray-100 tracking-normal"
                >
                    <tr>
                        <th class="th">
                            <input
                                type="checkbox"
                                class="h-4 w-4 cursor-pointer focus:outline-none "
                                @click="selectAll"
                                v-model="allSelected"
                            />
                        </th>
                        <th class="th">Itemcode</th>
                        <th class="th">Description</th>
                        <th class="th">Category Name</th>
                        <th class="th"></th>
                    </tr>
                </thead>
                <tbody class="tbody text-center">
                    <tr class="tr" v-if="!Items.length">
                        <td colspan="5" class="td ">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(item, i) in Items" :key="i" class="tr">
                        <td class="td">
                            <input
                                type="checkbox"
                                class="h-4 w-4 cursor-pointer focus:outline-none checked:bg-yellow-500"
                                :value="item.itemcode"
                                v-model="form.itemIds"
                                @click="select"
                            />
                        </td>
                        <td class="td">{{ item.itemcode }}</td>
                        <td class="td">{{ item.product_name }}</td>
                        <td class="td">{{ item.category_name }}</td>
                        <td class="td">
                            <a
                                v-if="item.items !== null"
                                @click="ItemEnable(item.itemcode)"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Disable Item"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-red-500"
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
                            </a>
                            <a
                                v-else
                                @click="ItemDisable(item.itemcode)"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Enable Item"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-green-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="border-t ">
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm  "
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
import { mapActions, mapState } from "vuex";
import Item from "../../../services/Item";
export default {
    data() {
        return {
            allSelected: false,
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                column: 1,
                dir: "desc",
                category: "",
                type: ""
            },
            form: {
                product_id: "",
                itemcode: "",
                quantity: "",
                product_name: "",
                image: "",
                status: "",
                previewImage: "",
                itemIds: []
            },
            index: -1,
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "isModal",
            "errors",
            "pagination",
            "ItemCategory",
            "Items"
        ])
    },
    methods: {
        ...mapActions(["modal", "getItemCategory", "getStoreItem"]),
        select() {
            this.allSelected = false;
        },
        selectAll() {
            this.form.itemIds = [];
            let item;
            if (!this.allSelected) {
                for (item in this.Items) {
                    this.form.itemIds.push(
                        this.Items[item].itemcode.toString()
                    );
                }
            }
        },
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
                category: this.tableData.category,
                type: this.tableData.type
            };
            this.getStoreItem({
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
        disableAll() {
            let itemcode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to disable the selected item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, disable it."
            }).then(result => {
                if (result.isConfirmed) {
                    Item.store_item_disable_all(itemcode).then(() => {
                        this.fetch();
                        this.form.itemIds = [];
                        this.allSelected = false;
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        enableAll() {
            let itemcode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to enable the selected item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, enable it."
            }).then(result => {
                if (result.isConfirmed) {
                    Item.store_item_enable_all(itemcode).then(() => {
                        this.fetch();
                        this.form.itemIds = [];
                        this.allSelected = false;
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        ItemEnable(itemcode) {
            swal.fire({
                title: "Are you sure?",
                text: "you want to enable this Item",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable it!"
            }).then(result => {
                if (result.isConfirmed) {
                    Item.tag_store_item_enable(itemcode).then(() => {
                        this.fetch();
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        ItemDisable(itemcode) {
            swal.fire({
                title: "Are you sure?",
                text: "you want to disable this Item",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disable it!"
            }).then(result => {
                if (result.isConfirmed) {
                    Item.tag_store_item_disable({ itemcode: itemcode }).then(
                        () => {
                            this.fetch();
                            toast.fire({
                                icon: "success",
                                title: "Success",
                                text: "Successfully changed"
                            });
                        }
                    );
                }
            });
        }
    },
    mounted() {
        this.fetch();
        this.getItemCategory();
    }
};
</script>
