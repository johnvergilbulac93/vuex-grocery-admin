<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="setup" />
        <div class="container bg-gray-50 shadow-lg p-5 rounded text-gray-800 ">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg "
                    >Business Rules</label
                >
            </div>
            <div
                class="grid lg:grid-flow-col lg:grid-cols-3 lg:grid-rows-1 sm:grid-flow-row sm:grid-cols-1 sm:grid-rows-1 gap-2"
            >
                <div class="p-2 tracking-normal">
                    <div class="flex flex-col space-y-2">
                        <fieldset class="p-2">
                            <legend class="text-sm px-2 mx-2 ">
                                Minimum Order Amount
                            </legend>
                            <input
                                tabindex="1"
                                type="number"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                        </fieldset>
                        <fieldset class="p-2">
                            <legend class="text-sm px-2 mx-2 ">
                                Pick-Up Charge
                            </legend>
                            <input
                                tabindex="2"
                                type="number"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                        </fieldset>
                        <fieldset class="p-2">
                            <legend class="text-sm px-2 mx-2 ">
                                Maximum no. of order
                            </legend>
                            <input
                                tabindex="3"
                                type="number"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                        </fieldset>
                        <fieldset class="p-2">
                            <legend class="text-sm px-2 mx-2 ">
                                Ordering Time Cut-off
                            </legend>
                            <label>Start</label>
                            <input
                                tabindex="4"
                                type="time"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                            <label>End</label>
                            <input
                                tabindex="5"
                                type="time"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                        </fieldset>
                        <fieldset class="p-2">
                            <legend class="text-sm px-2 mx-2 ">
                                Serving Time
                            </legend>
                            <label>Start</label>
                            <input
                                tabindex="6"
                                type="time"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                            <label>End</label>
                            <input
                                tabindex="7"
                                type="time"
                                class="w-full text-sm px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500"
                            />
                        </fieldset>
                    </div>

                    <div class="w-full mt-8 flex space-x-2">
                        <button
                            tabindex="4"
                            class="w-1/2 bg-blue-500 py-2 px-4 text-white text-sm hover:bg-blue-600 transition duration-500 focus:outline-none rounded"
                        >
                            Save
                        </button>
                        <button
                            tabindex="5"
                            class="w-1/2 bg-gray-500  py-2 px-4 text-white text-sm  hover:bg-gray-600 transition duration-500 focus:outline-none rounded"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div
                class="grid lg:grid-flow-row lg:grid-cols-3 lg:grid-rows-2 md:grid-flow-row md:grid-cols-2 md:grid-rows-3 sm:grid-flow-col sm:grid-cols-1 sm:grid-rows-6 gap-4"
            >
                <div class="bg-gray-50 h-72 w-full px-10 py-5 border">
                    <div class="flex flex-col space-y-12">
                        <label for="minAmount" class="text-lg tracking-wider"
                            >Minimum Order Amount</label
                        >
                        <div class="tracking-normal">
                            <label for="amount" class="font-semibold"
                                >Amount</label
                            >
                            <input
                                type="number"
                                v-bind:class="{
                                    'border-red-600': errors.min_amount
                                }"
                                v-model="form.min_amount"
                                class="w-full px-4 py-2 text-center text-sm rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.min_amount"
                            >
                                <small>{{ errors.min_amount[0] }}</small>
                            </p>
                        </div>

                        <button
                            @click="setMinAmount"
                            class="w-full bg-blue-500 py-2 rounded text-white text-sm hover:bg-blue-600 transition duration-500 focus:outline-none "
                        >
                            Save
                        </button>
                    </div>
                </div>
                <div class="bg-gray-50 h-72 w-full  px-10 py-5 border">
                    <div class="flex flex-col space-y-12 ">
                        <label for="pcharge" class="text-lg tracking-wider"
                            >Pick-Up Charge</label
                        >
                        <div class="tracking-normal">
                            <label for="amount" class="font-semibold"
                                >Amount</label
                            >
                            <input
                                type="number"
                                v-bind:class="{
                                    'border-red-600': errors.pickup_charge
                                }"
                                v-model="form.pickup_charge"
                                class="w-full px-4 py-2 text-center text-sm  rounded-lg border focus:outline-none focus:border-yellow-500 "
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.pickup_charge"
                            >
                                <small>{{ errors.pickup_charge[0] }}</small>
                            </p>
                        </div>

                        <button
                            @click="setPickupChargeAmount"
                            class="w-full bg-blue-500 py-2 rounded text-white text-sm  hover:bg-blue-600 transition duration-500 focus:outline-none "
                        >
                            Save
                        </button>
                    </div>
                </div>
                <div class="bg-gray-50 h-72 w-full  px-10 py-5 border ">
                    <div class="flex flex-col space-y-12 ">
                        <label for="maxorder" class="text-lg tracking-wider"
                            >Maximum no. of order</label
                        >
                        <div class="tracking-normal">
                            <label for="max" class="font-semibold"
                                >Max. no.</label
                            >
                            <input
                                type="number"
                                v-bind:class="{
                                    'border-red-600': errors.max_no_order
                                }"
                                v-model="form.max_no_order"
                                class="w-full px-4 py-2 text-center text-sm  rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.max_no_order"
                            >
                                <small>{{ errors.max_no_order[0] }}</small>
                            </p>
                        </div>

                        <button
                            @click="setMaxOrder"
                            class="w-full bg-blue-500 py-2 rounded text-white text-sm hover:bg-blue-600 transition duration-500 focus:outline-none"
                        >
                            Save
                        </button>
                    </div>
                </div>
                <div class="bg-gray-50 h-72 w-full  px-10 py-5 border">
                    <div class="flex flex-col space-y-2 text-black">
                        <label for="ordertime" class="text-lg tracking-wider"
                            >Ordering Time Cut-off</label
                        >
                        <div class="tracking-normal">
                            <label for="start" class="font-semibold"
                                >Start</label
                            >
                            <input
                                type="time"
                                v-bind:class="{
                                    'border-red-600':
                                        errors.order_time_cutoff_start
                                }"
                                v-model="form.order_time_cutoff_start"
                                class="w-full px-4 py-2 text-center text-sm  rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.order_time_cutoff_start"
                            >
                                <small>{{
                                    errors.order_time_cutoff_start[0]
                                }}</small>
                            </p>
                            <label for="End" class="font-semibold">End</label>
                            <input
                                type="time"
                                v-bind:class="{
                                    'border-red-600':
                                        errors.order_time_cutoff_end
                                }"
                                v-model="form.order_time_cutoff_end"
                                class="w-full px-4 py-2 text-center text-sm  rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.order_time_cutoff_end"
                            >
                                <small>{{
                                    errors.order_time_cutoff_end[0]
                                }}</small>
                            </p>
                        </div>

                        <button
                            @click="setOrderTimeCutoff"
                            class=" w-full bg-blue-500 py-2 rounded text-white  text-sm  hover:bg-blue-600 transition duration-500 focus:outline-none"
                        >
                            Save
                        </button>
                    </div>
                </div>
                <div class="bg-gray-50 h-72 w-full px-10 py-5 border">
                    <div class="flex flex-col space-y-2 ">
                        <label for="servetime" class="text-lg tracking-wider "
                            >Serving Time</label
                        >
                        <div class="tracking-normal">
                            <label for="start" class="font-semibold"
                                >Start</label
                            >
                            <input
                                type="time"
                                v-bind:class="{
                                    'border-red-600': errors.time_start_cutoff
                                }"
                                v-model="form.time_start_cutoff"
                                class="w-full px-4 py-2 text-center text-sm rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.time_start_cutoff"
                            >
                                <small>{{ errors.time_start_cutoff[0] }}</small>
                            </p>
                            <label for="End" class="font-semibold">End</label>
                            <input
                                type="time"
                                v-bind:class="{
                                    'border-red-600': errors.time_end_cutoff
                                }"
                                v-model="form.time_end_cutoff"
                                class="w-full px-4 py-2 text-center text-sm rounded-lg border focus:outline-none focus:border-yellow-500"
                            />
                            <p
                                class="text-red-500 text-center text-sm"
                                v-if="errors.time_end_cutoff"
                            >
                                <small>{{ errors.time_end_cutoff[0] }}</small>
                            </p>
                        </div>

                        <button
                            @click="setServingTimeCutoff"
                            class=" w-full bg-blue-500 py-2 rounded text-white text-sm  hover:bg-blue-600 transition duration-500 focus:outline-none "
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
import Breadcrumb from "./../../../Usable/Breadcrumb";

export default {
    components: {
        Breadcrumb
    },
    data() {
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
        return {
            routes: routes,
            form: {
                min_amount: "",
                pickup_charge: "",
                order_time_cutoff_start: "",
                order_time_cutoff_end: "",
                time_start_cutoff: "",
                time_end_cutoff: "",
                max_no_order: ""
            }
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapActions([
            "minamount",
            "pickupCharge",
            "maxOrder",
            "orderTimeCutoff",
            "servingTime"
        ]),
        async loadSetup() {
            const { data } = await axios.get("api/setup_rules");
            this.form.min_amount = parseFloat(data[0].minimum_order_amount);
            this.form.pickup_charge = parseFloat(data[0].pickup_charge);
            this.form.order_time_cutoff_start =
                data[0].ordering_cutoff_time_start;
            this.form.order_time_cutoff_end = data[0].ordering_cutoff_time_end;
            this.form.time_start_cutoff = data[0].serving_time_start;
            this.form.time_end_cutoff = data[0].serving_time_end;
            this.form.max_no_order = data[0].maximum_no_of_orders;
        },
        setMinAmount() {
            let minAmount = {
                id: 1,
                min_amount: this.form.min_amount
            };
            this.minamount({
                minAmount: minAmount
            });
            this.errors.min_amount = "";
        },
        setPickupChargeAmount() {
            let chargeAmount = {
                id: 1,
                pickup_charge: this.form.pickup_charge
            };
            this.pickupCharge({
                chargeAmount: chargeAmount
            });
            this.errors.pickup_charge = "";
        },
        setMaxOrder() {
            let maxOrder = {
                id: 1,
                max_no_order: this.form.max_no_order
            };
            this.maxOrder({
                maxOrder: maxOrder
            });
            this.errors.max_no_order = "";
        },
        setOrderTimeCutoff() {
            let timeCutoff = {
                id: 1,
                order_time_cutoff_start: this.form.order_time_cutoff_start,
                order_time_cutoff_end: this.form.order_time_cutoff_end
            };
            this.orderTimeCutoff({
                timeCutoff: timeCutoff
            });
            this.errors.order_time_cutoff_start = "";
            this.errors.order_time_cutoff_end = "";
        },
        setServingTimeCutoff() {
            let timeCutoff = {
                id: 1,
                time_start_cutoff: this.form.time_start_cutoff,
                time_end_cutoff: this.form.time_end_cutoff
            };
            this.servingTime({
                timeCutoff: timeCutoff
            });
            this.errors.time_start_cutoff = "";
            this.errors.time_end_cutoff = "";
        }
    },
    mounted() {
        this.loadSetup();
    }
};
</script>
