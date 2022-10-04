<template>
    <div class="container mx-auto">
        <div class="min-h-screen bg-gray-900">
            <div class="min-h-screen pb-8 max-w-7xl mx-auto bg-gray-100">
                <header class="p-4 shadow-md">
                    <h1 class="leading-8 font-bold">Dashboard</h1>
                </header>
                <div class="px-6">
                    <div class="py-4">
                        <search
                            id="search"
                            name="search"
                            :tracked-currencies="getCurrenciesName()"
                            @addTracked="addInTracked"
                            @removeTracked="removeFromTracked"
                        />
                    </div>
                    <ul class="grid grid-cols-5 gap-4 auto-rows-fr py-4 overflow-y-auto">
                        <li v-for="currency in currencies">
                            <crypto-card
                                @setCurrency="addToGraph"
                                @removeCurrency="removeFromGraph"
                                :key="currency.id"
                                :image="currency.imageUrl"
                                :name="currency.name"
                                :price="currency.history.at(-1).amount"
                            />
                        </li>
                    </ul>
                </div>
                <div class="container px-6 mt-6">
                    <form @submit.prevent="handleSubmit" class="flex items-center">
                        <div class="pr-4">
                            <label>
                                Start datetime
                                <input
                                    class="rounded-lg"
                                    type="date"
                                    v-model="dates.startDate"
                                    name="startdate"
                                    id="startdate"
                                >
                            </label>
                        </div>
                        <div class="pr-4">
                            <label>
                                End datetime
                                <input
                                    class="rounded-lg"
                                    type="date"
                                    v-model="dates.endDate"
                                    name="enddate"
                                    id="enddate"
                                >
                            </label>
                        </div>
                        <button
                            type="submit"
                            class="p-2 px-4 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                        >
                            Submit
                        </button>
                    </form>
                    <template v-if="chartData.length">
                        <line-chart
                            :raw-data="chartData"
                        />
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import cryptoCard from "../components/CryptoCard.vue";
import {getTrackedCurrenciesHistory, postTrackedCurrencies, removeTrackedCurrency,} from "../axios/trackedCurrency.js";
import lineChart from "../components/LineChart.vue";
import search from "../components/UI/Search.vue";


export default {
    components: {
        cryptoCard,
        lineChart,
        search
    },
    data() {
        return {
            currencies: [],
            chartData: [],
            selected: [],
            dates: {
                startDate: '',
                endDate: '',
            }
        }
    },
    watch: {
        selected(newValue, oldValue) {

            if (newValue.length < oldValue.length) {
                const afterRemoveData = this.chartData.filter((obj1) => {
                    return newValue.includes(obj1.name);
                });

                this.chartData = afterRemoveData;

            } else {
                const newCurrency = newValue.filter((item) => {
                    return oldValue.indexOf(item) === -1;
                });

                const queryParams = {
                    cs: newCurrency,
                    dfrom: this.dates.startDate,
                    dto: this.dates.endDate
                };

                getTrackedCurrenciesHistory(queryParams)
                    .then((res) => {
                        if (res.status === 200) {
                            this.chartData = [
                                ...this.chartData,
                                res.data.data[0]
                            ];
                        }
                    });

            }
        },
    },
    mounted() {
        getTrackedCurrenciesHistory()
            .then((res) => {
                if (res.status === 200) {
                    this.currencies = res.data.data
                }
            });
    },
    methods: {
        addToGraph(value) {
            this.selected = [
                ...this.selected,
                value
            ];
        },
        removeFromGraph(value) {
            this.selected = this.selected.filter(item => {
                return item !== value;
            });
        },
        handleSubmit() {
            const queryParams = {
                cs: this.selected,
                dfrom: this.dates.startDate,
                dto: this.dates.endDate
            };

            getTrackedCurrenciesHistory(queryParams)
                .then((res) => {
                    if (res.status === 200) {
                        this.chartData = null;
                        this.chartData = res.data.data;
                    }
                });
        },
        getCurrenciesName() {
            return this.currencies.map(currency => currency.name);
        },
        addInTracked(name) {
            postTrackedCurrencies([name])
                .then(res => {
                    if (res.status === 200) {
                        const queryParams = {
                            cs: [name],
                        };

                        getTrackedCurrenciesHistory(queryParams)
                            .then((res) => {
                                if (res.status === 200) {
                                    this.currencies = [
                                        ...this.currencies,
                                        ...res.data.data
                                    ];
                                }
                            });
                    }
                })
        },
        removeFromTracked(name) {
            removeTrackedCurrency(name)
                .then(res => {
                    if (res.status === 200) {
                        this.currencies = this.currencies
                            .filter(currency => currency.name !== name);
                    }
                })
        },
    },
    computed: {}
}
</script>
