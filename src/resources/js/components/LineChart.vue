<template>
    <LineChartGenerator
        :chart-options="chartOptions"
        :chart-data="chartData"
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
            chartData: {
                labels: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July'
                ],
                datasets: [
                    {
                        label: 'btc',
                        data: [4, 66, 22, 88, 4, 2]
                    },
                    {
                        label: 'eth',
                        data: [34, 66, 22, 7, 4, 9, 0]
                    }
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted: {
        rest: () => console.log('sdsss'),
    },
    computed: {
        // getChartData() {
        //     return {
        //         labels: [
        //             'January',
        //             'February',
        //             'March',
        //             'April',
        //             'May',
        //             'June',
        //             'July'
        //         ],
        //         // datasets: this.getDatasets()
        //         datasets: [
        //             {
        //                 label: 'btc',
        //                 data: [4, 66, 22, 88, 4, 2]
        //             },
        //             {
        //                 label: 'eth',
        //                 data: [34, 66, 22, 7, 4, 9, 0]
        //             }
        //         ],
        //     }
        // },
    },
    methods: {
        getDatasets() {
            console.log(this.currencies);
            return this.currencies.map((currency) => {
                console.log(this.getChartXData(currency.data));
                return {
                    label: currency.name,
                    data: this.getChartXData(currency.data)
                }
            });
        },
        getChartXData(data) {
            return data.map((item) => {
                return item.price;
            });
        }
    }
}


</script>
