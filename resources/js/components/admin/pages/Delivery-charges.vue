<template>
    <div class="container text-gray-800">
        <div class=" bg-gray-50 shadow-lg p-5 rounded ">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="tracking-wider text-lg"
                    >Delivery Charges</label
                >
            </div>
            <div class="grid grid-cols-6 grid-flow-col gap-4 mb-2">
                <div class="col-span-5 flex items-center space-x-2">
                    <div class="w-80 flex">
                        <div
                            class="relative w-full border overflow-hidden flex rounded-l-lg "
                        >
                            <input
                                type="text"
                                class="relative py-2 px-4 focus:outline-none w-full "
                                placeholder="Search...."
                                v-model="tableData.search"
                                @keyup.enter="search"
                            />
                            <button
                                @click="clear"
                                v-if="tableData.search.length"
                                class="absolute right-0 z-10   pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
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
                            class="py-2.5 px-4 border-r border-t border-b border-gray-200 focus:outline-none hover:bg-yellow-500 hover:text-white rounded-r-lg"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 "
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
                    <div class="w-56">
                        <!-- <span class="mb-10 font-semibold">Province</span> -->
                        <div class="">
                            <select
                                @change="fetch()"
                                class="text-sm py-2 px-4 focus:outline-none cursor-pointer border rounded-lg  w-full"
                                v-model="tableData.province"
                            >
                                <option value="">Choose Province</option>
                                <option
                                    v-for="(prov, index) in Provinces"
                                    :key="index"
                                    :value="prov.prov_id"
                                >
                                    {{ prov.prov_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-56 ">
                        <!-- <span class="mb-10 font-semibold ">Town</span> -->
                        <div class="">
                            <select
                                @change="fetch()"
                                class="text-sm py-2 px-4 focus:outline-none cursor-pointer border rounded-lg  w-full"
                                v-model="tableData.town"
                            >
                                <option value="">Choose Town</option>
                                <option
                                    v-for="(town, index) in Towns"
                                    :key="index"
                                    :value="town.town_id"
                                >
                                    {{ town.town_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-56">
                        <!-- <span class="mb-10 font-semibold "
                                >Transportation</span
                            > -->
                        <div class="">
                            <select
                                @change="fetch()"
                                class="py-2 px-4 focus:outline-none cursor-pointer border rounded-lg w-full"
                                v-model="tableData.transportation"
                            >
                                <option value="">Choose Transportation</option>
                                <option
                                    v-for="(transpo, index) in Transportations"
                                    :key="index"
                                    :value="transpo.id"
                                >
                                    {{ transpo.transpo_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end ">
                    <div class="text-sm mt-1">
                        <span>Show</span>
                        <select
                            class="mb-2 py-2 px-4 focus:outline-none cursor-pointer border rounded-lg "
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
            </div>

            <Datatable
                :columns="columns"
                :sortKey="sortKey"
                :sortOrders="sortOrders"
                @sort="sortBy"
            >
                <tbody class="tbody ">
                    <tr class="tr" v-if="!DCharges.length">
                        <td colspan="8" class=" td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(charge, i) in DCharges" :key="i" class="tr ">
                        <td class="td ">{{ charge.prov_name }}</td>
                        <td class="td">{{ charge.town_name }}</td>
                        <td class="td">
                            {{ !charge.brgy ? "" : charge.brgy.brgy_name }}
                        </td>
                        <td class="td">{{ charge.transpo_name }}</td>
                        <td class="td text-center">
                            {{ charge.charge_amt | toCurrency2 }}
                        </td>
                        <td class="td text-center">
                            {{ charge.rider_shared | toCurrency2 }}
                        </td>
                        <td class="td text-center" v-if="charge.status == 1">
                            <span
                                class="bg-green-400 px-2 py-1 rounded-full text-white  text-xs hover:bg-green-500 hover:text-white transition duration-500"
                            >
                                Active</span
                            >
                        </td>
                        <td class="text-center" v-else>
                            <span
                                class="bg-red-500 px-2 py-1 rounded-full text-white  text-xs hover:bg-red-600 hover:text-white transition duration-500"
                            >
                                Inactive</span
                            >
                        </td>
                        <td class="td text-center">
                            <button
                                class="p-1 focus:outline-none"
                                @click="remove(charge.chrg_id)"
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
                                class="p-i focus:outline-none"
                                @click="updateModal(charge)"
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
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                    />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </Datatable>
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
                    class="bg-black bg-opacity-40 fixed top-16 left-0 flex justify-center items-center w-full min-h-screen"
                >
                    <div
                        class="sm:w-full lg:w-1/2  bg-white rounded sm:m-5 md:m-5"
                    >
                        <div
                            class="p-2 flex justify-between items-center text-lg tracking-wider"
                        >
                            <label for="" v-if="!editMode"
                                >Setup new delivery charges</label
                            >
                            <label for="" v-if="editMode"
                                >Update delivery charges</label
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
                        <div class="w-full p-5 border-b border-t text-sm">
                            <div class="flex flex-col w-1/2">
                                <label for="province" class="font-semibold"
                                    >Province</label
                                >
                                <select
                                    @change="filteredTown"
                                    v-bind:class="{
                                        'border-red-600': errors.province
                                    }"
                                    class="px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                    v-model="form.province"
                                >
                                    <option value="">Select Province</option>
                                    <option
                                        :value="prov.prov_id"
                                        v-for="(prov, index) in Provinces"
                                        :key="index"
                                    >
                                        {{ prov.prov_name }}
                                    </option>
                                </select>
                                <p
                                    class="text-red-500 text-center text-sm"
                                    v-if="errors.province"
                                >
                                    <small>{{ errors.province[0] }}</small>
                                </p>
                            </div>
                            <div class="flex flex-row space-x-4 my-2 w-full ">
                                <div class="flex flex-col w-1/2">
                                    <label for="town" class="font-semibold"
                                        >Town</label
                                    >
                                    <select
                                        v-if="editMode"
                                        class=" px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                        v-model="form.town"
                                    >
                                        <option value="">Select Town</option>
                                        <option
                                            :value="town.town_id"
                                            v-for="(town, index) in Towns"
                                            :key="index"
                                        >
                                            {{ town.town_name }}
                                        </option>
                                    </select>
                                    <select
                                        v-else
                                        @change="filteredBrgy"
                                        v-bind:class="{
                                            'border-red-600': errors.town
                                        }"
                                        class=" px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                        v-model="form.town"
                                    >
                                        <option value="">Select Town</option>
                                        <option
                                            :value="town.town_id"
                                            v-for="(town, index) in filterTowns"
                                            :key="index"
                                        >
                                            {{ town.town_name }}
                                        </option>
                                    </select>
                                    <p
                                        class="text-red-500 text-center text-sm"
                                        v-if="errors.town"
                                    >
                                        <small>{{ errors.town[0] }}</small>
                                    </p>
                                </div>
                                <div class="flex flex-col w-1/2 ">
                                    <label for="brgy" class="font-semibold"
                                        >Barangay
                                        <small class="text-blue-600"
                                            >(Optional)</small
                                        >
                                    </label>
                                    <select
                                        v-if="editMode"
                                        class=" px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                        v-model="form.barangay"
                                    >
                                        <option value=""
                                            >Select Barangay</option
                                        >
                                        <option
                                            :value="brgy.brgy_id"
                                            v-for="(brgy, index) in Barangays"
                                            :key="index"
                                        >
                                            {{ brgy.brgy_name }}
                                        </option>
                                    </select>
                                    <select
                                        v-else
                                        v-bind:class="{
                                            'border-red-600': errors.barangay
                                        }"
                                        class=" px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                        v-model="form.barangay"
                                    >
                                        <option value=""
                                            >Select Barangay</option
                                        >
                                        <option
                                            :value="brgy.brgy_id"
                                            v-for="(brgy,
                                            index) in filterBarangays"
                                            :key="index"
                                        >
                                            {{ brgy.brgy_name }}
                                        </option>
                                    </select>
                                    <p
                                        class="text-red-500 text-center text-sm"
                                        v-if="errors.barangay"
                                    >
                                        <small>{{ errors.barangay[0] }}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label for="transpo" class="font-semibold"
                                    >Transportation</label
                                >
                                <select
                                    v-bind:class="{
                                        'border-red-600': errors.transportation
                                    }"
                                    class=" px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                    v-model="form.transportation"
                                >
                                    <option value=""
                                        >Select Transportation</option
                                    >
                                    <option
                                        :value="transpo.id"
                                        v-for="(transpo,
                                        index) in Transportations"
                                        :key="index"
                                    >
                                        {{ transpo.transpo_name }}
                                    </option>
                                </select>
                                <p
                                    class="text-red-500 text-center text-sm"
                                    v-if="errors.transportation"
                                >
                                    <small>{{
                                        errors.transportation[0]
                                    }}</small>
                                </p>
                            </div>
                            <div class="flex flex-row space-x-4 my-2">
                                <div class="flex flex-col w-1/2">
                                    <label for="D-Charges" class="font-semibold"
                                        >Delivery Charge</label
                                    >
                                    <input
                                        v-model="form.charge_amount"
                                        v-bind:class="{
                                            'border-red-600':
                                                errors.charge_amount
                                        }"
                                        type="number"
                                        class="text-center  px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                    />
                                    <p
                                        class="text-red-500 text-center text-sm"
                                        v-if="errors.charge_amount"
                                    >
                                        <small>{{
                                            errors.charge_amount[0]
                                        }}</small>
                                    </p>
                                </div>
                                <div class="flex flex-col w-1/2 ">
                                    <label for="brgy" class="font-semibold"
                                        >Rider Share</label
                                    >
                                    <input
                                        v-model="form.rider_share"
                                        v-bind:class="{
                                            'border-red-600': errors.rider_share
                                        }"
                                        type="number"
                                        class="text-center  px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
                                    />
                                    <p
                                        class="text-red-500 text-center text-sm"
                                        v-if="errors.rider_share"
                                    >
                                        <small>{{
                                            errors.rider_share[0]
                                        }}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input
                                    id="status"
                                    v-model="form.status"
                                    type="checkbox"
                                    :checked="[form.status == 1]"
                                    tabindex="3"
                                    class="w-5 h-5 appearance-none rounded bg-white checked:bg-yellow-600 checked:border-gray-300 border cursor-pointer"
                                />
                                <label
                                    for="status"
                                    class="  cursor-pointer font-semibold"
                                    >Status</label
                                >
                            </div>
                        </div>
                        <div
                            class="p-2 flex justify-end items-center space-x-1 text-sm"
                        >
                            <button
                                v-if="!editMode"
                                @click="create"
                                class="px-4 py-2 bg-blue-500 text-white text-sm hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Save
                            </button>
                            <button
                                v-if="editMode"
                                @click="update"
                                class="px-4 py-2 bg-blue-500 text-white -text-sm hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Update
                            </button>
                            <button
                                @click="closeModal"
                                class="px-4 py-2 bg-red-500 text-white text-sm hover:bg-red-600 rounded transition duration-500 focus:outline-none"
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
            <!-- <i class="text-white fas fa-plus fa-2x "></i> -->
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-white font-bold mx-auto"
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
import { mapActions, mapState } from "vuex";

export default {
    name: "Delivery-Charged",
    components: { Datatable },

    data() {
        let sortOrders = {};
        let columns = [
            {
                width: "15%",
                label: "Province",
                name: "prov_id",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Town",
                name: "town_id",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Barangay",
                name: "brgy_id",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Transportation",
                name: "transpo_id",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Charge Amount",
                name: "charge_amt",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Rider Share",
                name: "rider_shared",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Status",
                name: "statuss",
                class: "text-center"
            },
            {
                width: "10%",
                label: "Action",
                name: "asd",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            editMode: false,
            columns: columns,
            sortKey: "id",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                town: "",
                province: "",
                transportation: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                province: "",
                town: "",
                barangay: "",
                transportation: "",
                charge_amount: "",
                rider_share: "",
                status: ""
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination",
            "Provinces",
            "filterTowns",
            "filterBarangays",
            "DCharges",
            "Transportations",
            "Towns",
            "isModal",
            "Barangays"
        ])
    },
    methods: {
        ...mapActions([
            "getProvince",
            "getBarangay",
            "getTown",
            "getTransportation",
            "getDCharges",
            "modal",
            "townFiltered",
            "brgyFiltered",
            "saveCharge",
            "updateCharge",
            "deleteCharge"
        ]),
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search() {
            this.fetch()
        },
        remove(id) {
            this.deleteCharge({
                id: id
            });
        },
        reset() {
            this.form.id = "";
            this.form.province = "";
            this.form.town = "";
            this.form.barangay = "";
            this.form.transportation = "";
            this.form.rider_share = "";
            this.form.charge_amount = "";
            this.errors.province = "";
            this.errors.town = "";
            this.errors.barangay = "";
            this.errors.transportation = "";
            this.errors.charge_amount = "";
            this.errors.rider_share = "";
        },
        filteredTown() {
            let province = {
                prov_id: this.form.province
            };
            this.townFiltered({ province });
        },
        filteredBrgy() {
            let town = {
                town_id: this.form.town
            };
            this.brgyFiltered({ town });
        },
        closeModal() {
            this.reset();
            this.editMode = false;
            this.modal({
                flag: false
            });
        },
        updateModal(charge) {
            this.reset();
            this.editMode = true;
            this.modal({
                flag: true
            });
            this.form.id = charge.chrg_id;
            this.form.province = charge.prov_id;
            this.form.town = charge.town_id;
            this.form.barangay = charge.brgy_id;
            this.form.transportation = charge.transpo_id;
            this.form.charge_amount = charge.charge_amt;
            this.form.rider_share = charge.rider_shared;
            this.form.status = charge.status;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.modal({
                flag: true
            });
        },
        update() {
            let charge = {
                id: this.form.id,
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                transportation: this.form.transportation,
                charge_amount: this.form.charge_amount,
                rider_share: this.form.rider_share,
                status: this.form.status
            };
            this.updateCharge({ charge });
        },
        create() {
            let charge = {
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                transportation: this.form.transportation,
                charge_amount: this.form.charge_amount,
                rider_share: this.form.rider_share
            };
            this.saveCharge({ charge });
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                province: this.tableData.province,
                town: this.tableData.town,
                transportation: this.tableData.transportation
            };
            this.getDCharges({
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
        Fire.$on("reload_charge", () => {
            this.fetch();
        });
        this.fetch();
        this.getBarangay();
        this.getTown();
        this.getProvince();
        this.getTransportation();
    }
};
</script>
