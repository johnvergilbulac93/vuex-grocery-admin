<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="setup" />
        <div class="container text-gray-800">
            <div class=" bg-gray-50 shadow-lg p-5 rounded overflow-x-auto">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class=" text-lg font-semibold"
                        >Manage User</label
                    >
                </div>

                <div
                    class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                >
                    <div class=" md:w-1/2 sm:w-full flex items-center gap-0.5 ">
                        <div class="relative w-1/2 flex items-center ">
                            <input
                                type="text"
                                class="form-search "
                                placeholder="Search"
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
                    <div class="text-sm">
                        <span>Show</span>
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
                        <span>Entries</span>
                    </div>
                </div>
                <Datatable
                    :columns="columns"
                    :sortKey="sortKey"
                    :sortOrders="sortOrders"
                    @sort="sortBy"
                >
                    <tbody class="tbody ">
                        <tr class="tr" v-if="!Users.length">
                            <td colspan="6" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(user, i) in Users" :key="i" class="tr">
                            <td class="td uppercase ">{{ user.name }}</td>
                            <td class="td  ">{{ user.username }}</td>
                            <td class="td">{{ user.business_unit }}</td>
                            <td class="td text-center">
                                {{ user.created_at | formatDateNoTime }}
                            </td>
                            <td
                                class="td text-center"
                                v-if="user.inactivity_date != null"
                            >
                                {{ user.inactivity_date | formatDateNoTime }}
                            </td>
                            <td class="td text-center" v-else></td>
                            <td class="td text-center" v-if="user.status == 1">
                                <a @click="statusActive(user)">
                                    <span
                                        class="bg-green-400 px-2 py-1 rounded-full text-gray-50  text-xs hover:bg-green-500 hover:text-white transition duration-500"
                                    >
                                        Active</span
                                    >
                                </a>
                            </td>
                            <td class="td text-center" v-else>
                                <a @click="statusInActive(user)">
                                    <span
                                        class="bg-red-500 px-2 py-1 rounded-full text-gray-50 text-xs hover:bg-red-600 hover:text-white transition duration-500"
                                    >
                                        Inactive</span
                                    >
                                </a>
                            </td>
                            <td class="td text-center">
                                <button
                                    class="p-1 focus:outline-none"
                                    @click="remove(user.id)"
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
                                    class="focus:outline-none"
                                    @click="editInfo(user)"
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
                <transition
                    enter-active-class="ease-out duration-500"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-300"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="isModal"
                        class="bg-black bg-opacity-40 fixed top-0 left-0 z-50 flex justify-center items-center w-full min-h-screen"
                    >
                        <div
                            class="lg:w-1/2 md:w-3/4 md:mx-0 bg-white rounded sm:w-full sm:m-5 md:m-5 lg:m-0"
                        >
                            <div class="p-2 flex justify-between items-center">
                                <label for="" class="text-lg font-semibold"
                                    >Manage User</label
                                >
                                <a
                                    @click="closeModal"
                                    class="transition duration-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-gray-700 hover:text-red-500"
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
                            </div>
                            <div class="p-2 border-b border-t">
                                <fieldset>
                                    <legend class=" px-2 mx-2 ">
                                        Registration Form
                                    </legend>
                                    <div
                                        class="flex sm:flex-col lg:items-center lg:flex-row "
                                    >
                                        <div class="p-2 w-full relative block">
                                            <label
                                                for="name"
                                                class="font-semibold"
                                                >Name &nbsp;
                                                <small class="text-blue-500"
                                                    >Type here to search.</small
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                list="employee"
                                                v-model="form.name"
                                                @keyup="autoComplete"
                                                class="form "
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
                                                    :message="errors.name[0]"
                                                    v-if="errors.name"
                                                />
                                            </transition>

                                            <div
                                                class="bg-gray-50 h-40 absolute mt-1 shadow-lg rounded py-2 overflow-y-scroll"
                                                style="width: 316px;"
                                                v-if="Employees.length"
                                            >
                                                <a
                                                    @click="selectEmp(employee)"
                                                    v-for="employee in Employees"
                                                    :key="employee.id"
                                                    class="block p-2 hover:bg-gray-100"
                                                    >{{ employee.name }}</a
                                                >
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <label
                                                for="name"
                                                class="block font-semibold"
                                                >Employee ID</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                v-model="form.employee_id"
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
                                                    :message="
                                                        errors.employee_id[0]
                                                    "
                                                    v-if="errors.employee_id"
                                                />
                                            </transition>
                                        </div>
                                    </div>

                                    <div class="p-2 w-full">
                                        <label
                                            for="username"
                                            class="block font-semibold"
                                            >Username</label
                                        >
                                        <input
                                            type="text"
                                            v-model="form.username"
                                            class="form "
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
                                                :message="errors.username[0]"
                                                v-if="errors.username"
                                            />
                                        </transition>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label
                                            for="usertype"
                                            class="block font-semibold"
                                            >User Type</label
                                        >
                                        <select
                                            name=""
                                            class="form "
                                            v-model="form.usertype"
                                        >
                                            <option value=""
                                                >Select Type</option
                                            >
                                            <option
                                                :value="type.id"
                                                v-for="type in UserTypes"
                                                :key="type.id"
                                                >{{ type.usertype }}</option
                                            >
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
                                                :message="errors.usertype[0]"
                                                v-if="errors.usertype"
                                            />
                                        </transition>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label
                                            for="store"
                                            class="block font-semibold"
                                            >Store</label
                                        >
                                        <select
                                            name=""
                                            class="form"
                                            v-model="form.store"
                                        >
                                            <option value=""
                                                >Select Store</option
                                            >
                                            <option
                                                :value="store.bunit_code"
                                                v-for="(store, i) in Stores"
                                                :key="i"
                                                >{{
                                                    store.business_unit
                                                }}</option
                                            >
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
                                    <div class="p-2 w-full">
                                        <label
                                            for="cpassword"
                                            class="block font-semibold"
                                            >Password</label
                                        >
                                        <input
                                            type="password"
                                            v-model="form.password"
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
                                                :message="errors.password[0]"
                                                v-if="errors.password"
                                            />
                                        </transition>
                                    </div>
                                </fieldset>
                            </div>

                            <div
                                class="p-2 flex justify-end items-center space-x-1"
                            >
                                <button
                                    v-if="!editMode"
                                    @click="create"
                                    class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                                >
                                    Save
                                </button>
                                <button
                                    v-if="editMode"
                                    @click="update"
                                    class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                                >
                                    Update
                                </button>
                                <button
                                    @click="closeModal"
                                    class="px-4 py-2 bg-red-500 text-white  hover:bg-red-600 rounded transition duration-500 focus:outline-none"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
            <button
                @click="addModal"
                v-if="!isModal"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add"
                class="fixed z-30 bottom-0 right-0 mb-16 mr-3 focus:outline-none bg-blue-400 hover:bg-blue-500 w-12 h-12 rounded-full shadow-xl transition duration-700 ease-in-out transform hover:scale-105 "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 mx-auto text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import _ from "lodash";

export default {
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
                width: "25%",
                label: "Full Name",
                name: "name",
                class: "text-left"
            },
            {
                width: "25%",
                label: "User Name",
                name: "uname",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Location",
                name: "loc",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Registered Date",
                name: "reg_date",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Date of Inactivity",
                name: "inactive_date",
                class: "text-center"
            },
            {
                width: "20%",
                label: "Status",
                name: "stat",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Action",
                name: "action",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            // start pagination
            columns: columns,
            routes: routes,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                column: 1,
                dir: "desc"
            },
            editMode: false,
            loading: true,
            searchEmployee: "",
            selectedData: false,
            form: {
                id: "",
                name: "",
                username: "",
                usertype: "",
                password: "",
                store: "",
                employee_id: ""
            },
            currentPage: 1
            // end form
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination",
            "isModal",
            "UserTypes",
            "Users",
            "Employees",
            "Stores",
            "isSuccess"
        ])
    },
    methods: {
        ...mapActions([
            "userType",
            "getStore",
            "getUser",
            "modal",
            "getEmployee",
            "saveUser",
            "deleteUser",
            "updateUser",
            "activeUser",
            "inactiveUser"
        ]),
        ...mapMutations(["CLEAR_EMPLOYEE"]),
        clearError() {
            this.errors.message = "";
        },
        statusActive(data) {
            let user = {
                id: data.id
            };
            this.activeUser({ user });
        },
        statusInActive(data) {
            let user = {
                id: data.id
            };
            this.inactiveUser({ user });
        },
        reset() {
            this.form.name = "";
            this.form.employee_id = "";
            this.form.store = "";
            this.form.username = "";
            this.form.usertype = "";
            this.errors.name = "";
            this.errors.store = "";
            this.errors.usertype = "";
            this.errors.username = "";
            this.errors.password = "";
            this.errors.employee_id = "";
            this.form.password = "";
        },
        update() {
            let user = {
                id: this.form.id,
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                employee_id: this.form.employee_id,
                store: this.form.store,
                password: this.form.password
            };
            this.updateUser({ user });
        },
        create() {
            let user = {
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                employee_id: this.form.employee_id,
                store: this.form.store,
                password: this.form.password
            };
            this.saveUser({ user });
        },
        clearSearchEmployee() {
            this.CLEAR_EMPLOYEE();
        },
        addModal() {
            this.editMode = false;
            this.reset();
            this.modal({
                flag: true
            });
        },
        closeModal() {
            this.clearSearchEmployee();
            this.editMode = false;
            this.modal({
                flag: false
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
        editInfo(user) {
            this.editMode = true;
            this.reset();
            this.form.id = user.id;
            this.form.name = user.name;
            this.form.username = user.username;
            this.form.store = user.bunit_code;
            this.form.employee_id = user.employee_id;
            this.form.usertype = user.usertype_id;
            this.modal({
                flag: true
            });
        },
        remove(id) {
            this.deleteUser({ id: id });
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
            this.getUser({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search() {
            this.fetch();
        },
        selectEmp(employee) {
            this.form.name = employee.name;
            this.form.employee_id = employee.emp_id;
            this.form.username = employee.emp_id;
            this.CLEAR_EMPLOYEE();
        },
        autoComplete: _.debounce(function() {
            this.getEmployee({
                employee: this.form.name
            });
        }, 1000),
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
        Fire.$on("reload_user", () => {
            this.fetch();
        });
        this.fetch();
        this.userType();
        this.getStore();
    }
};
</script>
