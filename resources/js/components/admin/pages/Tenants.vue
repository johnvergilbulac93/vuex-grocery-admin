<template>
    <div class="container bg-gray-50 shadow-lg p-5 rounded text-gray-500">
        <div class="mb-5 bg-gray-100 p-2">
            <label for="" class="text-gray-500 text-lg font-semibold"
                >Tenant</label
            >
        </div>
        <div
            class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2"
        >
            <div class="p-2">
                <form @submit.prevent="editMode ? update() : create()">
                    <div class="flex flex-col space-y-2">
                        <div class="w-full space-y-1">
                            <label for="store">Store</label>
                            <select
                                v-model="form.store"
                                tabindex="1"
                                v-bind:class="{
                                    'border-red-600': errors.store
                                }"
                                class="w-full font-semibold px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
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
                            <label for="store">Department</label>
                            <select
                                v-model="form.department"
                                tabindex="2"
                                v-bind:class="{
                                    'border-red-600': errors.department
                                }"
                                class="w-full font-semibold px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            >
                                <option value="">Select Department</option>
                                <option
                                    :value="dept.dept_id"
                                    v-for="dept in Departments"
                                    :key="dept.dept_id"
                                    >{{ dept.name }}
                                </option>
                            </select>
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.department"
                            >
                                <small>{{ errors.department[0] }}</small>
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input
                                v-model="form.status"
                                type="checkbox"
                                :checked="[form.status == 1]"
                                tabindex="3"
                                class="w-6 h-6 appearance-none rounded bg-white checked:bg-yellow-600 checked:border-gray-300 border-2 cursor-pointer"
                            />
                            <label
                                for="store"
                                class="font-semibold text-gray-500 text-md tracking-normal"
                                >Status</label
                            >
                        </div>
                    </div>

                    <button
                        tabindex="4"
                        class="my-3 w-full bg-yellow-500 py-2 px-4 text-white font-semibold hover:bg-yellow-600 transition duration-500 focus:outline-none"
                    >
                        {{ !editMode ? "Save" : "Update" }}
                    </button>
                </form>
                <button
                    @click="reset"
                    tabindex="5"
                    class="w-full bg-gray-500  py-2 px-4 text-white font-semibold hover:bg-gray-600 transition duration-500 focus:outline-none"
                >
                    Clear
                </button>
            </div>
            <div class="col-span-2">
                <div
                    class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                >
                    <div class=" text-gray-600 md:w-1/2 sm:w-full flex">
                        <div
                            class="relative w-1/2 border overflow-hidden flex rounded-l-lg"
                        >
                            <input
                                type="text"
                                class="relative py-2 px-4 pr-10 w-full outline-none text-gray-600 placeholder-gray-400 focus:outline-none "
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
                            class="py-2 px-4 border-r border-t border-b border-gray-200 focus:outline-none hover:bg-yellow-500 text-gray-500 hover:text-white rounded-r-lg"
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
                        <tr class="tr" v-if="!Tenants.length">
                            <td colspan="4" class="td font-semibold">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr class="tr" v-for="(tenant, i) in Tenants" :key="i">
                            <a @click="editInfo(tenant)"
                                ><td class="td">
                                    {{ tenant.business_unit }}
                                </td></a
                            >
                            <td class="td">{{ tenant.name }}</td>
                            <td class="td">
                                <span
                                    class=" px-2 py-1 text-white font-bold rounded-full"
                                    :class="[
                                        tenant.status
                                            ? 'bg-green-500'
                                            : 'bg-red-500'
                                    ]"
                                    >{{
                                        tenant.status ? "Active" : "Inactive"
                                    }}</span
                                >
                            </td>
                            <td>
                                <button
                                    class="p-1 focus:outline-none"
                                    @click="remove(tenant.tenant_id)"
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
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </Datatable>
                <div class="border-t ">
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm  text-gray-600"
                            >Showing
                            {{ !pagination.from ? 0 : pagination.from }} to
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
    </div>
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState } from "vuex";
export default {
    name: "Tenants",
    components: {
        Datatable
    },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "70%", label: "Store", name: "description" },
            { width: "20%", label: "Department", name: "category" },
            { width: "20%", label: "Status", name: "status" },
            { width: "10%", label: "", name: "idss" }
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
            "errors"
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
            this.reset();
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
