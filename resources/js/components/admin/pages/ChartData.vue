<script>
import { Doughnut } from "vue-chartjs";
const options = {
    responsive: true,
    maintainAspectRatio: false,
    animation: {
        animateRotate: false
    }
};
export default {
    extends: Doughnut,
    // mixins: [mixins.reactiveProp],
    props: ["Data", "Labels", "options"],
    data() {
        return {};
    },
    methods: {
        loadChart: function() {
            this.renderChart(
                {
                    labels: this.Labels,
                    datasets: [
                        {
                            backgroundColor: [
                                "#34D399",
                                "#F59E0B",
                                "#B45309",
                                "#DC2626"
                            ],
                            data: this.Data
                        }
                    ]
                },
                { responsive: true, maintainAspectRatio: false }
            );
        }
    },
    watch: {
        data: function() {
            this._chart.destroy();
            this.loadChart();
        }
    },
    mounted() {
        // this.renderChart(this.chartData, this.options);
        this.loadChart();
    }
};
</script>
x
