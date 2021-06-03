<template>
    <div class="container">
        <div class=" bg-gray-50 shadow-lg p-5 rounded">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-gray-500 text-lg font-semibold"
                    >Manage User</label
                >
            </div>
            <div
                class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
            >
                <div class=" text-gray-600 md:w-1/2 sm:w-full flex">
                    <div
                        class="relative w-64 border overflow-hidden flex rounded-l-lg"
                    >
                        <input
                            type="text"
                            class="relative py-2 px-4 pr-10 w-full outline-none text-gray-600 placeholder-gray-400 focus:outline-none "
                            placeholder="Search"
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
                    <tr class="tr" v-if="!Users.length">
                        <td colspan="6" class="td font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(user, i) in Users" :key="i" class="tr">
                        <td class="td">
                            <button
                                class="p-1 focus:outline-none"
                                @click="remove(user.id)"
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
                        <td class="td uppercase">{{ user.name }}</td>
                        <td class="td">{{ user.username }}</td>
                        <td class="td">{{ user.usertype }}</td>
                        <td class="td">{{ user.business_unit }}</td>
                        <td class="td">
                            <button
                                class="focus:outline-none"
                                @click="editInfo(user)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500 hover:text-green-500"
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
                    class="bg-black bg-opacity-40 fixed top-14 left-0 flex justify-center items-center w-full min-h-screen"
                >
                    <div
                        class="lg:w-1/2 md:w-3/4 md:mx-0 bg-white rounded sm:w-full sm:m-5 md:m-5 lg:m-0"
                    >
                        <div class="p-2 flex justify-between items-center">
                            <label for="" class="text-lg text-gray-600"
                                >Manage User</label
                            >
                            <a
                                @click="closeModal"
                                class="transition duration-500"
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
                            </a>
                        </div>
                        <div class="p-2 border-b border-t">
                            <fieldset>
                                <legend
                                    class="text-gray-600 font-semibold tracking-normal px-2 mx-2 "
                                >
                                    Registration Form
                                </legend>
                                <div
                                    class="flex sm:flex-col lg:items-center lg:flex-row "
                                >
                                    <div class="p-2 w-full relative block">
                                        <label for="name" class=""
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
                                            class="w-full form-input font-semibold "
                                        />
                                        <div
                                            class="bg-gray-50 h-40 absolute mt-1 shadow-lg rounded py-2 overflow-y-scroll"
                                            style="width: 301px;"
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
                                        <label for="name" class="block"
                                            >Employee ID</label
                                        >
                                        <input
                                            type="text"
                                            disabled
                                            v-model="form.emp_id"
                                            class="w-full form-input font-semibold"
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <label for="username" class="block"
                                        >Username</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.username"
                                        class="w-full form-input font-semibold"
                                    />
                                </div>
                                <div class="p-2 w-full">
                                    <label for="usertype" class="block"
                                        >User Type</label
                                    >
                                    <select
                                        name=""
                                        class="w-full form-input font-semibold"
                                        v-model="form.usertype"
                                    >
                                        <option value="">Select Type</option>
                                        <option
                                            :value="type.id"
                                            v-for="type in UserTypes"
                                            :key="type.id"
                                            >{{ type.usertype }}</option
                                        >
                                    </select>
                                </div>
                                <div class="p-2 w-full">
                                    <label for="store" class="block"
                                        >Store</label
                                    >
                                    <select
                                        name=""
                                        class="w-full form-input font-semibold"
                                        v-model="form.store"
                                    >
                                        <option value="">Select Store</option>
                                        <option
                                            :value="store.bunit_code"
                                            v-for="(store, i) in Stores"
                                            :key="i"
                                            >{{ store.business_unit }}</option
                                        >
                                    </select>
                                </div>
                                <div class="p-2 w-full">
                                    <label for="cpassword" class="block"
                                        >Password</label
                                    >
                                    <input
                                        type="password"
                                        v-model="form.password"
                                        class="w-full form-input "
                                    />
                                </div>
                            </fieldset>
                        </div>

                        <div
                            class="p-2 flex justify-end items-center space-x-2"
                        >
                            <button
                                v-if="!editMode"
                                @click="create"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Save
                            </button>
                            <button
                                v-if="editMode"
                                @click="update"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Update
                            </button>
                            <button
                                @click="closeModal"
                                class="px-4 py-2 bg-red-500 text-white font-semibold hover:bg-red-600 rounded transition duration-500 focus:outline-none"
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
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState, mapMutations } from "vuex";
import _ from "lodash";

export default {
    components: { Datatable },

    data() {
        let sortOrders = {};
        let columns = [
            { width: "5%", label: "", name: "id" },
            { width: "25%", label: "Name", name: "name" },
            { width: "15%", label: "User Name", name: "username" },
            { width: "15%", label: "User Type", name: "usertype_id" },
            { width: "20%", label: "Location", name: "bunit_code" },
            { width: "15%", label: "", name: "idss" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            // start pagination
            columns: columns,
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
                emp_id: ""
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
            "Stores"
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
            "updateUser"
        ]),
        ...mapMutations(["CLEAR_EMPLOYEE"]),
        reset() {
            this.form.name = "";
            this.form.emp_id = "";
            this.form.store = "";
            this.form.username = "";
            this.form.usertype = "";
        },
        update() {
            let user = {
                id: this.form.id,
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                emp_id: this.form.emp_id,
                store: this.form.store,
                password: this.form.password
            };
            this.updateUser({ user });
            this.fetch();
        },
        create() {
            let user = {
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                emp_id: this.form.emp_id,
                store: this.form.store,
                password: this.form.password
            };
            this.saveUser({ user });
            this.fetch();
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
            this.form.emp_id = user.emp_id;
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
            this.form.emp_id = employee.emp_id;
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
        this.fetch();
        this.userType();
        this.getStore();
    }
};
</script>
