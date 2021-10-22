<template>
    <div
        class="relative bg-gray-50 shadow-lg p-2 rounded text-gray-800   overflow-x-auto"
    >
        <router-link
            to="/bu_time"
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

        <div class="space-y-3 mt-5">
            <div class="space-y-1 ">
                <label class="font-bold">Store</label>
                <select class="form" v-model="store">
                    <option value="">Select Store</option>
                    <option
                        :value="store.bunit_code"
                        v-for="store in Stores"
                        :key="store.bunit_code"
                        >{{ store.business_unit }}
                    </option>
                </select>
                <div class="space-y-1">
                    <label class="font-bold">Start</label>
                    <input
                        tabindex="2"
                        type="time"
                        class="form"
                        v-model="opening_time"
                    />
                </div>
                <div class="space-y-1 ">
                    <label class="font-bold">End</label>
                    <input
                        tabindex="2"
                        type="time"
                        class="form"
                        v-model="closing_time"
                    />
                </div>
            </div>
            <button
                @click="save"
                class="w-full bg-blue-500 p-2 mt-3 flex gap-1 justify-center items-center text-center text-white focus:outline-none focus:bg-blue-600"
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
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                    />
                </svg>
                <span>Update</span>
            </button>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import StoreHour from "./../../../services/StoreHour";
export default {
    data() {
        return {
            id: this.$route.params.id,
            store: "",
            opening_time: "",
            closing_time: "",
            loading: false
        };
    },
    computed: {
        ...mapState(["Stores"])
    },
    methods: {
        ...mapActions(["saveStoreHour"]),
        async fetch() {
            this.loading = true;
            try {
                const { data, status } = await StoreHour.show_by_id(this.id);
                if (status === 200) {
                    this.store = data[0].bunit_code;
                    this.opening_time = data[0].time_in;  
                    this.closing_time = data[0].time_out;
                    this.loading = false;
                }
            } catch (error) {
                console.log(error);
                this.loading = false;
            }
        },
        save() {
            let storehour = {
                id: this.id,
                store: this.store,
                opening_time: this.opening_time,
                closing_time: this.closing_time
            };
            this.saveStoreHour({ storehour });
            Fire.$on("reload_time", () => {
                this.$router.push("/bu_time").catch(() => {});
            });
        }
    },
    mounted() {
        this.fetch();
    }
};
</script>

