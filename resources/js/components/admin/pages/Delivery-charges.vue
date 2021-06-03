<template>
    <div class="container">
        <div class=" bg-gray-50 shadow-lg p-5 rounded ">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-gray-500 text-lg font-semibold"
                    >Delivery Charges</label
                >
            </div>
            <div>
                <div
                    class="flex sm:flex-wrap md:flex-row  sm:flex-col sm:space-y-2 justify-between items-center pb-2"
                >
                    <div
                        class="w-1/2 flex md:flex-row justify-between sm:flex-col "
                    >
                        <div class="w-56">
                            <span class="mb-10  text-gray-600">Province</span>
                            <div class="py-1">
                                <select
                                    @change="fetch()"
                                    class="font-semibold py-2 px-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 w-full"
                                    v-model="tableData.province"
                                >
                                    <option value="">Select Province</option>
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
                        <div class="w-56 md:mr-2 md:ml-2 sm:mr-0 sm:ml-0">
                            <span class="mb-10 text-gray-600 ">Town</span>
                            <div class="py-1">
                                <select
                                    @change="fetch()"
                                    class="font-semibold py-2 px-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 w-full"
                                    v-model="tableData.town"
                                >
                                    <option value="">Select Town</option>
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
                            <span class="mb-10 text-gray-600"
                                >Transportation</span
                            >
                            <div class="py-1">
                                <select
                                    @change="fetch()"
                                    class="font-semibold py-2 px-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 w-full"
                                    v-model="tableData.transportation"
                                >
                                    <option value=""
                                        >Select Transportation</option
                                    >
                                    <option
                                        v-for="(transpo,
                                        index) in Transportations"
                                        :key="index"
                                        :value="transpo.id"
                                    >
                                        {{ transpo.transpo_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-600">
                        <span class="text-sm">Show</span>
                        <select
                            @change="fetch()"
                            class="py-2 px-4 mt-4 focus:outline-none cursor-pointer border rounded-lg text-gray-600 "
                            v-model="tableData.length"
                        >
                            <option
                                v-for="(records, index) in perPage"
                                :key="index"
                                :value="records"
                            >
                                {{ records }}
                            </option>
                        </select>
                        <span class="text-sm">Entries</span>
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
                            <td colspan="8" class=" font-semibold td">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(charge, i) in DCharges" :key="i" class="tr">
                            <td class="td">
                                <button
                                    class="p-1 focus:outline-none"
                                    @click="remove(charge.chrg_id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 hover:text-red-600"
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
                            <td class="td">{{ charge.prov_name }}</td>
                            <td class="td">{{ charge.town_name }}</td>
                            <td class="td">
                                {{ !charge.brgy ? "" : charge.brgy.brgy_name }}
                            </td>
                            <td class="td">{{ charge.transpo_name }}</td>
                            <td class="td">{{ charge.charge_amt }}</td>
                            <td class="td">{{ charge.rider_shared }}</td>
                            <td class="td">
                                <button class="p-i focus:outline-none" @click="updateModal(charge)">
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
                    class="bg-black bg-opacity-40 fixed top-10 left-0 flex justify-center items-center w-full min-h-screen"
                >
                    <div
                        class="sm:w-full lg:w-1/2  bg-white rounded sm:m-5 md:m-5"
                    >
                        <div class="p-2 flex justify-between items-center">
                            <label for="" class="text-xl font-semibold text-gray-500"
                                >Setup new delivery charges</label
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
                        <div class="w-full p-5 border-b border-t">
                            <div class="flex flex-col w-1/2">
                                <label for="province">Province</label>
                                <select
                                    @change="filteredTown"
                                    v-bind:class="{
                                        'border-red-600': errors.province
                                    }"
                                    class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                            <div class="flex flex-row space-x-4 my-4 w-full ">
                                <div class="flex flex-col w-1/2">
                                    <label for="town">Town</label>
                                    <select
                                        v-if="editMode"
                                        class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                                        class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                                    <label for="brgy"
                                        >Barangay
                                        <small class="text-blue-600"
                                            >(Optional)</small
                                        >
                                    </label>
                                    <select
                                        v-if="editMode"
                                        class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                                        class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                                <label for="transpo">Transportation</label>
                                <select
                                    v-bind:class="{
                                        'border-red-600': errors.transportation
                                    }"
                                    class="font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                            <div class="flex flex-row space-x-4 my-4">
                                <div class="flex flex-col w-1/2">
                                    <label for="D-Charges"
                                        >Delivery Charge</label
                                    >
                                    <input
                                        v-model="form.charge_amount"
                                        v-bind:class="{
                                            'border-red-600':
                                                errors.charge_amount
                                        }"
                                        type="number"
                                        class="text-center font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
                                    <label for="brgy">Rider Share</label>
                                    <input
                                        v-model="form.rider_share"
                                        v-bind:class="{
                                            'border-red-600': errors.rider_share
                                        }"
                                        type="number"
                                        class="text-center font-semibold px-4 py-2 border focus:outline-none focus:border-yellow-500 rounded"
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
            { width: "10%", label: "", name: "id" },
            { width: "15%", label: "Province", name: "prov_id" },
            { width: "15%", label: "Town", name: "town_id" },
            { width: "15%", label: "Barangay", name: "brgy_id" },
            { width: "15%", label: "Transportation", name: "transpo_id" },
            { width: "15%", label: "Charge Amount", name: "charge_amt" },
            { width: "15%", label: "Rider Share", name: "rider_shared" },
            { width: "10%", label: "", name: "" }
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
                rider_share: ""
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
                rider_share: this.form.rider_share
            };
            this.updateCharge({ charge });
            this.fetch();
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
            this.fetch();
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
        this.fetch();
        this.getBarangay();
        this.getTown();
        this.getProvince();
        this.getTransportation();
    }
};
</script>
