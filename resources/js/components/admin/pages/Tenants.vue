<template>
    <div class="space-y-2">
        <Breadcrumb :routes="SetupMenu" title="setup" />
        <div class="bg-gray-50 shadow-lg p-2 rounded text-gray-800">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class=" text-lg font-semibold">Tenant</label>
            </div>
            <div
                class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2"
            >
                <div class="p-2">
                    <transition
                        enter-active-class="ease-in duration-500"
                        enter-class="opacity-0 "
                        enter-to-class="opacity-100"
                        leave-active-class="ease-out duration-500"
                        leave-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <ErrorMessage
                            :message="errors.message[0]"
                            v-if="errors.message"
                            @clear="clearError"
                        />
                    </transition>

                    <form @submit.prevent="editMode ? update() : create()">
                        <div class="flex flex-col space-y-2">
                            <div class="w-full space-y-1">
                                <label for="store" class="font-semibold"
                                    >Store</label
                                >
                                <select
                                    v-model="form.store"
                                    tabindex="1"
                                    class="form"
                                >
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
                                <label for="store" class="font-semibold"
                                    >Department</label
                                >
                                <select
                                    v-model="form.department"
                                    tabindex="2"
                                    class="form"
                                >
                                    <option value="">Select Department</option>
                                    <option
                                        :value="dept.dept_id"
                                        v-for="dept in Departments"
                                        :key="dept.dept_id"
                                        >{{ dept.name }}
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
                                        :message="errors.department[0]"
                                        v-if="errors.department"
                                    />
                                </transition>
                            </div>
                            <div class="flex items-center space-x-1 DURA ">
                                <input
                                    id="status"
                                    v-model="form.status"
                                    type="checkbox"
                                    :checked="[form.status == 1]"
                                    tabindex="3"
                                    class="form-checkbox "
                                />
                                <label
                                    for="status"
                                    class=" text-md cursor-pointer font-semibold"
                                    >Status</label
                                >
                            </div>
                        </div>

                        <button
                            tabindex="4"
                            class="my-3 w-full bg-blue-500 py-2 px-4 text-white text-sm hover:bg-blue-600 transition duration-500 focus:outline-none rounded"
                        >
                            {{ !editMode ? "Save" : "Update" }}
                        </button>
                    </form>
                    <button
                        @click="reset"
                        tabindex="5"
                        class="w-full bg-gray-500  py-2 px-4 text-white text-sm hover:bg-gray-600 transition duration-500 focus:outline-none rounded "
                    >
                        Clear
                    </button>
                </div>
                <div class="col-span-2">
                    <div
                        class="flex sm:flex-wrap justify-between items-center mb-2"
                    >
                        <div
                            class=" md:w-1/2 sm:w-full flex items-center gap-0.5"
                        >
                            <div class="relative w-full  flex items-center">
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
                                    class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
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
                            <tr class="tr" v-if="!Tenants.length">
                                <td
                                    colspan="4"
                                    class="td font-semibold text-center"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr
                                class="tr"
                                v-for="(tenant, i) in Tenants"
                                :key="i"
                            >
                                <td class="td text-left">
                                    {{ tenant.business_unit }}
                                </td>
                                <td class="td">{{ tenant.name }}</td>
                                <td class="td text-center">
                                    <span
                                        class=" px-2 py-1 text-white text-xs rounded-full"
                                        :class="[
                                            tenant.status
                                                ? 'bg-green-500'
                                                : 'bg-red-500'
                                        ]"
                                        >{{
                                            tenant.status
                                                ? "Active"
                                                : "Inactive"
                                        }}</span
                                    >
                                </td>
                                <td class="text-center border">
                                    <button
                                        class="p-1 focus:outline-none"
                                        @click="remove(tenant.tenant_id)"
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
                                        @click="editInfo(tenant)"
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
    name: "Tenants",
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
                label: "Department",
                name: "category",
                class: "text-left"
            },
            {
                width: "20%",
                label: "Status",
                name: "status",
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
            columns: columns,
            sortKey: "deadline",
            sortOrders: sortOrders,
            form: {
                id: "",
                store: "",
                department: "",
                status: ""
            },
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
            "Departments",
            "pagination",
            "perPage",
            "Tenants",
            "errors",
            "SetupMenu"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "getDepartment",
            "showTenant",
            "saveTenant",
            "updateTenant",
            "deleteTenant"
        ]),
        editInfo(tenant) {
            this.reset();
            this.editMode = true;
            this.form.id = tenant.tenant_id;
            this.form.store = tenant.bunit_code;
            this.form.department = tenant.dept_id;
            this.form.status = tenant.status;
        },
        clearError() {
            this.errors.message = "";
        },
        remove(id) {
            this.deleteTenant({
                id: id
            });
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
            this.showTenant({
                currentPage: this.currentPage,
                filterData: filterData
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
        reset() {
            this.form.id = "";
            this.form.store = "";
            this.form.department = "";
            this.form.status = "";
            this.errors.store = "";
            this.errors.department = "";
            this.errors.message= "";
            this.editMode = false;
        },
        update() {
            let tenant = {
                id: this.form.id,
                store: this.form.store,
                department: this.form.department,
                status: this.form.status
            };
            this.updateTenant({
                tenant: tenant
            });
            this.reset();
        },
        create() {
            let tenant = {
                store: this.form.store,
                department: this.form.department,
                status: this.form.status
            };
            this.saveTenant({
                tenant: tenant
            });
            Fire.$on("reload_tenant", () => {
                this.reset();
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
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
        Fire.$on("reload_tenant", () => {
            this.fetch();
        });
        this.fetch();
        this.getStore();
        this.getDepartment();
    }
};
</script>
