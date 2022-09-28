<template>
    <input
        class="w-full rounded-lg"
        type="text"
        name="search"
        @input="debouncedHandler"
        id="search"
    >
</template>

<script>
import {debounce} from "lodash";
import {getTrackedCurrenciesHistory, getTrackedCurrencyHistories} from "../../axios/currency";

export default {
    name: "Search",
    components: {},
    props: {
        name: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            details: [],
            value: ''
        }
    },
    created() {
        this.debouncedHandler = debounce(event => {
            console.log(event);
                getTrackedCurrencyHistories(event.target.value)
                    .then((res) => {
                        console.log(res);
                    })
        }, 700);
    },
    beforeUnmount() {
        this.debouncedHandler.cancel();
    }
}
</script>

