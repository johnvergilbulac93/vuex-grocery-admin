<template>
    <div class="space-y-2">
        <Breadcrumb :routes="SetupMenu" title="setup" />
        <div
            class=" bg-gray-50 shadow-lg p-2 rounded text-gray-800   overflow-x-auto"
        >
            <div class="mb-2 bg-gray-100 p-2 w-full">
                <label class="font-semibold md:text-lg sm:text-xl "
                    >Business Rules</label
                >
            </div>
            <div class="sm:hidden lg:block">
                <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="border bg-gray-100 tracking-normal ">
                        <tr>
                            <th class="th text-left border">
                                Minimum Order Amount
                            </th>
                            <th class="th text-left border">
                                Pick-Up Charge
                            </th>
                            <th class="th text-center border">
                                Maximum no. of order
                            </th>
                            <th
                                class="th text-center border"
                                colspan="2"
                                rowspan="2"
                            >
                                Ordering Time Cut-off
                                <hr />
                                <tr
                                    class="flex justify-around items-center mt-1"
                                >
                                    <th>Start</th>
                                    <th>End</th>
                                </tr>
                            </th>

                            <th class="th text-center border" colspan="2">
                                Serving Time
                                <hr />
                                <tr
                                    class="flex justify-around items-center mt-1"
                                >
                                    <th>Start</th>
                                    <th>End</th>
                                </tr>
                            </th>

                            <th class="text-center p-1">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        <tr class="border" v-for="(rule, i) in Rules" :key="i">
                            <td class="p-2 border">
                                {{ rule.minimum_order_amount | toCurrency2 }}
                            </td>
                            <td class="p-2 border">
                                {{ rule.pickup_charge | toCurrency2 }}
                            </td>
                            <td class="p-2 border text-center">
                                {{ rule.maximum_no_of_orders }}
                            </td>
                            <td class="p-2 border text-center">
                                {{
                                    rule.ordering_cutoff_time_start
                                        | formatTime2
                                }}
                            </td>
                            <td class="p-2 border text-center">
                                {{
                                    rule.ordering_cutoff_time_end | formatTime2
                                }}
                            </td>
                            <td class="p-2 border text-center">
                                {{ rule.serving_time_start | formatTime2 }}
                            </td>
                            <td class="p-2 border text-center">
                                {{ rule.serving_time_end | formatTime2 }}
                            </td>
                            <td class="p-2 text-center">
                                <button
                                    @click="update(rule)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Edit"
                                    class="focus:outline-none hover:text-green-600"
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
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="lg:hidden sm:block">
                <table
                    class="min-w-full divide-y divide-gray-300  "
                    v-for="(rule, i) in Rules"
                    :key="i"
                >
                    <thead class="border bg-gray-200 tracking-normal ">
                        <tr>
                            <th class="th text-center border">
                                Minimum Order Amount
                            </th>
                            <th class="th text-center border" colspan="2">
                                Pick-Up Charge
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center p-2">
                                {{ rule.minimum_order_amount | toCurrency2 }}
                            </td>
                            <td class="text-center p-2">
                                {{ rule.pickup_charge | toCurrency2 }}
                            </td>
                        </tr>
                    </tbody>
                    <thead class="border bg-gray-200 tracking-normal ">
                        <tr>
                            <th class="th text-center border" colspan="2">
                                Maximum no. of order
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center p-2" colspan="2">
                                {{ rule.maximum_no_of_orders }}
                            </td>
                        </tr>
                    </tbody>
                    <thead class="border bg-gray-200 tracking-normal ">
                        <tr>
                            <th
                                class="th text-center border"
                                colspan="2"
                                rowspan="2"
                            >
                                Ordering Time Cut-off
                                <hr />
                                <tr
                                    class="flex justify-around items-center mt-1"
                                >
                                    <th>Start</th>
                                    <th>End</th>
                                </tr>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center p-2">
                                {{
                                    rule.ordering_cutoff_time_start
                                        | formatTime2
                                }}
                            </td>
                            <td class="text-center p-2">
                                {{
                                    rule.ordering_cutoff_time_end | formatTime2
                                }}
                            </td>
                        </tr>
                    </tbody>
                    <thead class="border bg-gray-200 tracking-normal ">
                        <tr>
                            <th
                                class="th text-center border"
                                colspan="2"
                                rowspan="2"
                            >
                                Serving Time
                                <hr />
                                <tr
                                    class="flex justify-around items-center mt-1"
                                >
                                    <th>Start</th>
                                    <th>End</th>
                                </tr>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center p-2">
                                {{ rule.serving_time_start | formatTime2 }}
                            </td>
                            <td class="text-center p-2">
                                {{ rule.serving_time_end | formatTime2 }}
                            </td>
                        </tr>
                    </tbody>
                    <thead class="border bg-gray-200 tracking-normal ">
                        <tr>
                            <th class="th text-center border" colspan="2">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-2" colspan="2">
                                <router-link
                                    :to="'/business_rules/' + rule.id"
                                    class="bg-green-500 p-2 flex justify-center focus:text-white text-white focus:outline-none focus:bg-green-600"
                                >
                                    <span class="flex justify-center"
                                        >Edit</span
                                    >
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <transition
                enter-active-class=" ease-in-out transition duration-500"
                enter-class="transform -translate-y-11 opacity-0 "
                enter-to-class="opacity-100"
                leave-active-class="ease-in-out transition duration-500"
                leave-class=" opacity-100"
                leave-to-class="transform -translate-y-11 opacity-0"
            >
                <div
                    v-if="isModal"
                    class=" fixed top-0 left-0 flex z-50 p-1 justify-center items-center w-full min-h-screen"
                >
                    <div class="sm:-full md:w-3/4 xl:w-1/2 bg-white  border border-gray-400 rounded shadow-lg ">
                        <div class="p-2 flex justify-between items-center  ">
                            <label class="font-semibold  xl:text-lg sm:text-sm "
                                >Update Business Rules</label
                            >
                            <a @click="close" class="transition duration-500">
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
                        <hr />
                        <div
                            class="flex justify-center items-center lg:p-2 sm:p-1  xl:text-sm sm:text-xs"
                        >
                            <fieldset class="p-1">
                                <legend class=" px-2 mx-2 ">
                                    Minimum Order Amount
                                </legend>
                                <input
                                    v-model="form.minimum_order_amount"
                                    tabindex="1"
                                    type="number"
                                    class="form"
                                />
                            </fieldset>

                            <fieldset class="p-1">
                                <legend class=" px-2 mx-2 ">
                                    Pick-Up Charge
                                </legend>
                                <input
                                    v-model="form.pickup_charge"
                                    tabindex="2"
                                    type="number"
                                    class="form"
                                />
                            </fieldset>
                            <fieldset class="p-1">
                                <legend class=" px-2 mx-2 ">
                                    Maximum no. of order
                                </legend>
                                <input
                                    v-model="form.maximum_no_of_order"
                                    tabindex="3"
                                    type="number"
                                    class="form"
                                />
                            </fieldset>
                        </div>
                        <div
                            class="flex justify-between gap-2 items-center p-2 xl:text-text-sm sm:text-xs "
                        >
                            <fieldset class="p-2">
                                <legend class=" px-2 mx-2 ">
                                    Ordering Time Cut-off
                                </legend>
                                <label>Start</label>
                                <input
                                    v-model="form.order_time_cutoff_start"
                                    tabindex="4"
                                    type="time"
                                    class="form"
                                />
                                <label>End</label>
                                <input
                                    v-model="form.order_time_cutoff_end"
                                    tabindex="5"
                                    type="time"
                                    class="form"
                                />
                            </fieldset>
                            <fieldset class="p-2">
                                <legend class="px-2 mx-2 ">
                                    Serving Time
                                </legend>
                                <label>Start</label>
                                <input
                                    v-model="form.serving_time_start"
                                    tabindex="6"
                                    type="time"
                                    class="form"
                                />
                                <label>End</label>
                                <input
                                    v-model="form.serving_time_end"
                                    tabindex="7"
                                    type="time"
                                    class="form"
                                />
                            </fieldset>
                        </div>
                        <hr />
                        <div
                            class="p-2 flex justify-end items-center space-x-1 xl:text-sm sm:text-xs"
                        >
                            <button
                                @click="save"
                                class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Save
                            </button>
                            <button
                                @click="close"
                                class="px-4 py-2 bg-red-500 text-white  hover:bg-red-600 rounded transition duration-500 focus:outline-none"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
import Breadcrumb from "./../../../Usable/Breadcrumb";
import Datatable from "./../../../Usable/Datatable";

export default {
    components: {
        Breadcrumb,
        Datatable
    },
    data() {
        return {
            form: {
                id: "",
                minimum_order_amount: "",
                pickup_charge: "",
                order_time_cutoff_start: "",
                order_time_cutoff_end: "",
                serving_time_start: "",
                serving_time_end: "",
                maximum_no_of_order: ""
            }
        };
    },
    computed: {
        ...mapState(["errors", "isModal", "Rules", "SetupMenu"])
    },
    methods: {
        ...mapActions(["modal", "saveRule", "getRules"]),
        update(rule) {
            this.reset();
            this.modal({
                flag: true
            });
            this.form.id = rule.id;
            this.form.minimum_order_amount = parseFloat(
                rule.minimum_order_amount
            );
            this.form.pickup_charge = parseFloat(rule.pickup_charge);
            this.form.order_time_cutoff_start = rule.ordering_cutoff_time_start;
            this.form.order_time_cutoff_end = rule.ordering_cutoff_time_end;
            this.form.serving_time_start = rule.serving_time_start;
            this.form.serving_time_end = rule.serving_time_end;
            this.form.maximum_no_of_order = rule.maximum_no_of_orders;
        },
        reset() {
            this.form.id = "";
            this.form.minimum_order_amount = "";
            this.form.pickup_charge = "";
            this.form.order_time_cutoff_start = "";
            this.form.order_time_cutoff_end = "";
            this.form.serving_time_start = "";
            this.form.serving_time_end = "";
            this.form.maximum_no_of_order = "";
        },

        close() {
            this.modal({
                flag: false
            });
            this.reset();
        },
        save() {
            let rule = {
                id: this.form.id,
                minimum_order_amount: this.form.minimum_order_amount,
                pickup_charge: this.form.pickup_charge,
                order_time_cutoff_start: this.form.order_time_cutoff_start,
                order_time_cutoff_end: this.form.order_time_cutoff_end,
                serving_time_start: this.form.serving_time_start,
                serving_time_end: this.form.serving_time_end,
                maximum_no_of_order: this.form.maximum_no_of_order
            };
            this.saveRule({ rule });
        }
    },
    mounted() {
        this.getRules();
        Fire.$on("reload_rules", () => {
            this.getRules();
        });
    }
};
</script>
