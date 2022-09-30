<template>
    <div class="h-screen flex flex-col sm:justify-center items-center p-6 bg-gray-900">
        <div
            class="lg:container  lg:mx-auto h-full sm:max-w-md px-6 py-6 pb-8 sm:rounded-lg bg-gray-100"
        >
            <h1 class="font-mono font-bold text-4xl">Preferences</h1>
            <h2 class="font-mono text-1xl mb-3">Select the currency you want to track</h2>
            <hr>
            <p v-if="error.isShow"
               class="my-2 text-sm text-red-600 dark:text-red-500">
                {{ error.message }}
            </p>
            <form @submit.prevent="handleSubmit" method="post">
                <ul class="grid grid-cols-5 gap-4 auto-rows-fr py-4 overflow-y-auto">
                    <li v-for="currency in currencies">
                        <crypto-card
                            @setCurrency="setTrackedCurrency"
                            @removeCurrency="removeTrackedCurrency"
                            :key="currency.id"
                            :image="currency.image"
                            :name="currency.name"
                            :price="currency.amount"
                        />
                    </li>
                </ul>
                <button type="submit"
                        class="p-2 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Accept
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import CryptoCard from "../components/CryptoCard.vue";

import {getTrackedCurrencies, postTrackedCurrencies} from "../axios/trackedCurrency.js";

export default {
    components: {
        CryptoCard,
    },
    data() {
        return {
            selected: [],
            currencies: [],
            error: {
                isShow: false,
                message: '',
            }
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
        handleSubmit() {
            const user = JSON.parse(localStorage.getItem('user'));

            postTrackedCurrencies(this.selected)
                .then((res) => {
                        if (res.status === 200) {
                            const newFirstLoginStatus = res.data.user.status

                            localStorage.removeItem('user');
                            localStorage.setItem(
                                'user',
                                JSON.stringify({
                                    ...user, ...{first_login: newFirstLoginStatus}
                                })
                            );

                            this.$router.push({name: 'home'});
                        }
                    }
                ).catch((err) => {
                this.error.isShow = true;
                this.error.message = err?.response.data.message;
            });
        },
        setTrackedCurrency(value) {
            this.selected.push(value);
        },
        removeTrackedCurrency(value) {
            this.selected = this.selected.filter(item => {
                return item !== value;
            });
        }
    }
}
</script>
