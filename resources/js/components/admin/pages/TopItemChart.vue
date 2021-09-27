<script>
import { Line } from "vue-chartjs";
export default {
    extends: Line,
    props: ["data", "labels", "year", "month"],
    computed: {
        chartData() {
            return this.data;
        },
        chartLabels() {
            return this.labels;
        },
        chartYear() {
            return moment(this.year).format("YYYY");
        },
        chartMonth(){
            return moment(this.month).format("MMMM");
        }
    },
    methods: {
        loadChart() {
            this.renderChart(
                {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            label: this.chartYear + '-' + this.chartMonth,
                            data: this.chartData,
                            backgroundColor: "#db5334",
                            borderColor: "#9CA3AF",
                            fill: false,
                            tension: 0.1
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: "TOP 10 ITEM"
                    },
                    tooltips: {
                        mode: "label",
                        intersect: false
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    },
                    scales: {
                        //     xAxes: [
                        //         {
                        //             display: true,
                        //             scaleLabel: {
                        //                 display: true,
                        //                 labelString: "Item Description"
                        //             }
                        //         }
                        //     ],
                        yAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: "Quantity"
                                },
                            }
                        ],
                    }
                }
            );
        }
    },
    watch: {
        data() {
            // this.$data._chart.destroy();
            this.loadChart();
        }
    },
    mounted() {
        this.loadChart();
    }
};
</script>
