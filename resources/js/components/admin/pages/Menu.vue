<template>
    <div class="flex gap-4  sm:flex-col lg:flex-row ">
        <SubMenu />
        <div class="w-1/2 sm:w-full  bg-gray-50 shadow-lg p-5 rounded">
            <div class="sm:w-full md:w-1/2">
                <div
                    class="bg-gray-100 h-40 flex flex-col justify-between items-center w-full rounded border shadow-lg"
                >
                    <div class="mt-5 text-gray-800 ">
                        <span>Today's Price Changed.</span>
                        <h3 class="text-7xl text-center">
                            {{ priceCount }}
                        </h3>
                    </div>
                    <a
                        @click="showModalPrice"
                        class="bg-blue-500 text-center py-2 text-white w-full hover:text-white hover:bg-blue-600 transition duration-500    "
                    >
                        <span class="">More info</span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="border-t mt-5 md:w-full">
                <div class="mb-5 bg-gray-100 p-2 w-full">
                    <label for="" class="text-gray-500 text-lg font-semibold"
                        >Item not available</label
                    >
                </div>
                <div class=" w-full min-h-screen">
                    <ChartData
                        refs="skills_chart"
                        :data="data"
                        :labels="labels"
                    >
                    </ChartData>
                </div>
            </div>

            <transition
                enter-active-class="ease-out duration-700"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-300"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="isModal"
                    class="bg-black bg-opacity-30 fixed top-0 left-0 z-50 flex justify-center items-center shadow-xl p-20 w-full min-h-screen"
                >
                    <div
                        class="bg-white md:w-full sm:max-w-full rounded text-gray-800"
                    >
                        <div
                            class="border-b-2 p-3 flex justify-between items-center"
                        >
                            <span class="font-semibold text-lg"
                                >Today's Price Changed</span
                            >
                            <a @click="closeModal">
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
                        <InfoPrice></InfoPrice>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import SubMenu from "./Sub-Menu.vue";
import InfoPrice from "./Info-Price-History.vue";
import { mapActions, mapState } from "vuex";
import ChartData from "./ChartData.vue";
export default {
    components: {
        InfoPrice,
        ChartData,
        SubMenu
    },
    data() {
        return {
            data: [],
            labels: []
        };
    },
    computed: {
        ...mapState(["isModal", "priceCount"])
    },
    methods: {
        ...mapActions(["modal", "getPriceChanged"]),

        showModalPrice() {
            this.modal({
                flag: true
            });
        },
        closeModal() {
            this.modal({
                flag: false
            });
        },
        async getItems(url = "/api/not_available_item") {
            let self = this;

            const { data } = await axios.get(url);

            let result = data;
            result.forEach(bu => {
                self.labels.push(bu.business_unit);
                self.data.push(bu.store);
            });
        },
        async getTopItems(url = "/api/top_items"){

            const { data } = await axios.get(url);
            console.log(data)
        }
    },
    mounted() {
        this.getPriceChanged();
        this.getItems();
        // this.getTopItems()
    }
};
</script>
