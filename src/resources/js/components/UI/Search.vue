<template>
    <div class="w-48">
        <input
            class="w-full rounded-lg"
            type="text"
            name="search"
            @input="debouncedHandler"
            id="search"
        >
        <ul class="">
            <li v-for="detail of details">
                <button
                    class="w-full"
                >
                    {{detail}}
                </button>
            </li>
        </ul>
    </div>

</template>

<script>
import {debounce} from "lodash";
import {getCurrencies} from "../../axios/currency.js";

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
            details: ['SOL', 'BTC', 'HTC'],
            value: ''
        }
    },
    created() {
        this.debouncedHandler = debounce(event => {
            const queryParams = {
              cs: event.target.value,
            };

            getCurrencies(queryParams)
                .then((res) => {
                    console.log(res.data);
                });

        }, 700);
    },
    beforeUnmount() {
        this.debouncedHandler.cancel();
    }
}
</script>

