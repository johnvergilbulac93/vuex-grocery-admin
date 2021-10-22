<template>
    <div
        class="relative bg-gray-50 shadow-lg p-2 rounded text-gray-800   overflow-x-auto"
    >
        <router-link
            to="/business_rules"
            class="flex gap-1 w-20 p-2  bg-green-500 text-white focus:text-white focus:bg-green-600 items-center"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                    clip-rule="evenodd"
                />
            </svg>
            <span>Back</span>
        </router-link>

        <div class="mt-5 space-y-3">
            <div class="space-y-1 ">
                <label class="font-bold">Minimum Order Amount</label>
                <input
                    type="number"
                    class="form"
                    v-model="minimum_order_amount"
                />
            </div>
            <div class="space-y-1">
                <label class="font-bold">Pick-Up Charge</label>
                <input type="number" class="form" v-model="pickup_charge" />
            </div>
            <div class="space-y-1">
                <label class="font-bold">Maximum no. of order</label>
                <input
                    type="number"
                    class="form"
                    v-model="maximum_no_of_order"
                />
            </div>
            <fieldset class="p-2">
                <legend class=" px-2 mx-2 font-bold">
                    Ordering Time Cut-off
                </legend>
                <label>Start</label>
                <input
                    type="time"
                    class="form"
                    v-model="order_time_cutoff_start"
                />
                <label>End</label>
                <input
                    type="time"
                    class="form"
                    v-model="order_time_cutoff_end"
                />
            </fieldset>
            <fieldset class="p-2">
                <legend class=" px-2 mx-2 font-bold">
                    Serving Time
                </legend>
                <label>Start</label>
                <input type="time" class="form" v-model="serving_time_start" />
                <label>End</label>
                <input type="time" class="form" v-model="serving_time_end" />
            </fieldset>
        </div>
        <button
            @click="save"
            class="w-full bg-blue-500 p-2 mt-3 text-center text-white focus:outline-none focus:bg-blue-600"
        >
            Update
        </button>

        <div
            class="absolute top-0 left-0 bg-white w-full min-h-full p-2"
            v-if="loading"
        >
            <SkeletonLoading />
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import Rules from "./../../../services/Rules";
export default {
    data() {
        return {
            id: this.$route.params.id,
            minimum_order_amount: "",
            pickup_charge: "",
            order_time_cutoff_start: "",
            order_time_cutoff_end: "",
            serving_time_start: "",
            serving_time_end: "",
            maximum_no_of_order: "",
            loading: false
        };
    },
    methods: {
        ...mapActions(["saveRule"]),
        async fetch() {
            try {
                this.loading = true;
                const { data, status } = await Rules.getRuleByID(this.id);
                if (status === 200) {
                    this.minimum_order_amount = parseFloat(
                        data.minimum_order_amount
                    );
                    this.pickup_charge = parseFloat(data.pickup_charge);
                    this.order_time_cutoff_start =
                        data.ordering_cutoff_time_start;
                    this.order_time_cutoff_end = data.ordering_cutoff_time_end;
                    this.serving_time_start = data.serving_time_start;
                    this.serving_time_end = data.serving_time_end;
                    this.maximum_no_of_order = data.maximum_no_of_orders;
                    this.loading = false;
                }
            } catch (error) {
                console.log(error);
                this.loading = false;
            }
        },
        save() {
            let rule = {
                id: this.id,
                minimum_order_amount: this.minimum_order_amount,
                pickup_charge: this.pickup_charge,
                order_time_cutoff_start: this.order_time_cutoff_start,
                order_time_cutoff_end: this.order_time_cutoff_end,
                serving_time_start: this.serving_time_start,
                serving_time_end: this.serving_time_end,
                maximum_no_of_order: this.maximum_no_of_order
            };
            this.saveRule({ rule });
            Fire.$on("reload_rules", () => {
               this.$router.push("/business_rules").catch(()=>{});
            });
        }
    },
    mounted() {
        this.fetch();
    }
};
</script>

<style></style>
