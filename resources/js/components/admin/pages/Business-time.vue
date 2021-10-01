<template>
    <div class="space-y-2">
        <Breadcrumb :routes="SetupMenu" title="Setup" />
        <div class="bg-gray-50 shadow-lg p-2 rounded text-gray-800 ">
            <div class="mb-5 bg-gray-100 p-2">
                <label class="font-semibold text-lg ">Store Time</label>
            </div>
            <div
                class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2 overflow-x-auto"
            >
                <div class="p-2 tracking-normal">
                    <div class="flex flex-col space-y-2">
                        <div class="w-full ">
                            <label for="store" class="font-semibold"
                                >Store</label
                            >
                            <select v-model="store" tabindex="1" class="form">
                                <option value="">Select Store</option>
                                <option
                                    :value="store.bunit_code"
                                    v-for="store in Stores"
                                    :key="store.bunit_code"
                                    >{{ store.business_unit }}
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
                        <div class="w-full space-y-1">
                            <label for="start" class="font-semibold"
                                >Start</label
                            >
                            <input
                                tabindex="2"
                                type="time"
                                v-model="opening_time"
                                class="form"
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
                                    :message="errors.opening_time[0]"
                                    v-if="errors.opening_time"
                                />
                            </transition>
                        </div>
                        <div class="w-full space-y-1">
                            <label for="end" class="font-semibold">End</label>
                            <input
                                tabindex="3"
                                type="time"
                                v-model="closing_time"
                                class="form"
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
                                    :message="errors.closing_time[0]"
                                    v-if="errors.closing_time"
                                />
                            </transition>
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
                        class="flex sm:flex-wrap sm:space-y-2 md:space-y-0  justify-between mb-2"
                    >
                        <div
                            class="md:w-1/2 sm:w-full flex items-center gap-0.5"
                        >
                            <div class="relative w-full  flex items-center   ">
                                <input
                                    type="text"
                                    class="form-search"
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
                            <button @click="search" class="button-search">
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
                        <div
                            class="justify-end items-center sm:hidden md:flex gap-1"
                        >
                            <span class="sm:hidden md:block">Show</span>
                            <select
                                class="form-sort"
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
                            <span class="sm:hidden md:block">Entries</span>
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
                                class="tr "
                                v-for="(data, i) in StoreHourList"
                                :key="i"
                            >
                                <td class="td">
                                    {{ data.business_unit }}
                                </td>
                                <td class="td text-center ">
                                    {{ data.time_in | formatTime2 }}
                                </td>
                                <td class="td text-center">
                                    {{ data.time_out | formatTime2 }}
                                </td>
                                <td class="td text-center ">
                                    <a href="#" @click="changeStatus(data)">
                                        <span
                                            class="text-gray-50 hover:text-white transition duration-500 font-semibold text-xs px-2 py-1 rounded-full"
                                            :class="
                                                data.status === 1
                                                    ? 'bg-green-400  hover:bg-green-500'
                                                    : 'bg-red-500  hover:bg-red-600'
                                            "
                                        >
                                            {{
                                                data.status === 1
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </span>
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </Datatable>
                    <Pagination
                        :pagination="pagination"
                        @prev="previousPage(pagination.prevPageUrl)"
                        @next="nextPage(pagination.nextPageUrl)"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    name: "Business-Time",
    data() {
        let sortOrders = {};
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
            editMode: false,
            selectedData: false,
            id: "",
            store: "",
            opening_time: "",
            closing_time: "",
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
            "perPage",
            "StoreHourList",
            "pagination",
            "Stores",
            "errors",
            "SetupMenu"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "showStoreHour",
            "saveStoreHour",
            "deleteStoreHour",
            "storeChangeStatus",
        ]),
        changeStatus(data) {
            let filter = {
                id: data.id,
                status: data.status
            };
            swal.fire({
                title: 'Confirmation',
                text: "Do you want to change the status?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, change it!"
            }).then(result => {
                if (result.isConfirmed) {
                   this.storeChangeStatus({ filter });
                }
            });
            
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
