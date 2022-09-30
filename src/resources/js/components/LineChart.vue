<template>
    <LineChartGenerator
        :chart-options="chartOptions"
        :chart-data="getChartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
    />
</template>
<script>
import {Line as LineChartGenerator} from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
} from 'chart.js';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
)

export default {
    name: "LineChart",
    components: {
        LineChartGenerator
    },
    props: {
        chartId: {
            type: String,
            default: 'line-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {
            }
        },
        plugins: {
            type: Array,
            default: () => []
        },
        rawData: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            chartData: this.getChartData,
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            }
        }
    },
    watch: {
    },
    computed: {
        getChartData() {
            return {
                labels: this.getLabelsData(),
                datasets: this.getDatasets(),
            }
        },
    },
    methods: {
        getDatasets() {
            return this.rawData.map((currency) => {
                const color = this.getRandomColor();

                return {
                    label: currency.name,
                    data: this.getChartYData(currency.history),
                    backgroundColor: color,
                    borderColor: color,
                }
            });
        },
        getLabelsData() {
            const data = this.rawData[0].history;

            const firstDate = new Date(data[0].date);
            const lastDate = new Date(data.at(-1).date);

            const isDayDateBetween = firstDate.getDay() === lastDate.getDay();

            return data.map((item) => {
                const date = new Date(item.date);

                if (isDayDateBetween) {
                    return date.getHours() + ':' + date.getMinutes();
                } else{
                    return date.getUTCDate() + '/' + date.getUTCMonth();
                }
            });
        },
        getChartYData(data) {
            return data.map((item) => {
                return item.amount;
            });
        },
        getRandomColor() {
            const letters = '0123456789ABCDEF'.split('');
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
    }
}


</script>
