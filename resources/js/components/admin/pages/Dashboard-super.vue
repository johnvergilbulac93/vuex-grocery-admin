<template>
    <div class="bg-gray-50 shadow-lg p-5 rounded ">
        <div class="grid grid-flow-col grid-cols-4 grid-rows-1 gap-4">
            <div
                class="bg-gray-100 h-40 flex flex-col justify-between items-center w-full rounded border shadow-lg"
            >
                <div class="mt-5">
                    <h3 class="text-7xl text-gray-500 text-center">
                        {{ priceCount }}
                    </h3>
                </div>
                <a
                    @click="showModalPrice"
                    class="bg-yellow-500 text-center py-2 text-white w-full hover:text-white hover:bg-yellow-600 transition duration-500    "
                >
                    <span class="">More info</span>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="border-t mt-5">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-gray-500 text-lg font-semibold"
                    >Item Count Not Available Per Store</label
                >
            </div>
            <ChartData refs="skills_chart" :Data="Data" :Labels="Labels" :Options="options">
            </ChartData>
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
                class="bg-black bg-opacity-30 fixed top-16  left-0 flex justify-center items-center shadow-xl p-20 w-full min-h-screen"
            >
                <div class="bg-white md:w-full sm:max-w-full rounded">
                    <div
                        class="border-b-2 p-3 flex justify-between items-center"
                    >
                        <span
                            class="tracking-tight text-gray-500 font-bold text-lg"
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
</template>

<script>
import InfoPrice from "./Info-Price-History.vue";
import { mapActions, mapState } from "vuex";
import ChartData from "./ChartData.vue";
export default {
    components: {
        InfoPrice,
        ChartData
    },
    data() {
        return {
            Data: [],
            Labels: [],
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    computed: {
        ...mapState(["isModal", "priceCount"])
    },
    methods: {
        ...mapActions(["modal", "getPriceChanged"]),
        // updateChart() {
        //     this.$refs.skills_chart.update();
        // },
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
        async getItems(url = "api/item_count_available") {
            let self = this;
            // axios.get(url).then(res => {
            //     const result = res.data;
            //     result.forEach(bu => {
            //         self.Labels.push(bu.business_unit);
            //         self.Data.push(bu.store);
            //     });
            // this.updateChart();

            const { data } = await axios.get(url);

            let result = data;
            result.forEach(bu => {
                self.Labels.push(bu.business_unit);
                self.Data.push(bu.store);
            });

            // });
        }
    },
    mounted() {
        this.getPriceChanged();
        this.getItems();
    }
};
</script>
