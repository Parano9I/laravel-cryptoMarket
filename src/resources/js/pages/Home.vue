<template>
    <div class="min-h-screen bg-gray-900">
        <div class="min-h-screen pb-8 max-w-7xl mx-auto bg-gray-100">
            <header class="p-4 shadow-md">
                <h1 class="leading-8 font-bold">Dashboard</h1>
            </header>
            <div class="container px-6">
                <ul class="grid grid-cols-5 gap-4 auto-rows-fr py-4 overflow-y-auto">
                    <li v-for="currency in currencies">
                        <crypto-card
                            @setCurrency="addToGraph"
                            @removeCurrency="removeFromGraph"
                            :key="currency.id"
                            :image="currency.image"
                            :name="currency.name"
                            :price="currency.data.at(-1).price"
                        />
                    </li>
                </ul>
            </div>
            <div class="container px-6">
                <line-chart
                    data="currencies"
                />
            </div>
        </div>
    </div>
</template>

<script>
import cryptoCard from "../components/CryptoCard.vue";
import {getTrackedCurrencies} from "../axios/currency.js";
import lineChart from "../components/LineChart.vue";


export default {
    components: {
        cryptoCard,
        lineChart
    },
    data() {
        return {
            currencies: [],
            selected: [],
        }
    },
    mounted() {
        getTrackedCurrencies()
            .then((res) => {
                if (res.status === 200) {
                    this.currencies = res.data.data
                }
            });
    },
    methods: {
        addToGraph(value) {
            this.selected.push(value);
        },
        removeFromGraph(value) {
            this.selected = this.selected.filter(item => {
                return item !== value;
            });
        },
    },
    computed: {}
}
</script>
