<template>
    <div class="relative w-1/3"
         @focusin="onFocus"
         @focusout.once="detailsIsShow = false"
    >
        <input
            class="w-full rounded-lg focus:border-transparent focus:border-solid focus:border-b focus:border-stone-500 focus:ring-0"
            type="text"
            name="search"
            @input="debouncedHandler"
            id="search"
        >
        <template v-if="detailsIsShow && details.at(-1)">
            <ul
                class="absolute bg-white w-full rounded-b-lg p-2"
            >
                <template v-for="detail of details">
                    <li class="border-solid border-b border-stone-500 last:border-b-0">
                        <div
                            class="flex justify-between py-2 w-full"
                            :key="detail.id"
                        >
                            <span>{{ detail.name }}</span>
                            <button
                                v-if="isTracked(detail.name)"
                                class="text-red-700"
                            >
                                Remove from tracked
                            </button>
                            <button
                                v-else
                                class="text-green-700"
                                @click.stop="addInTracked(detail.name)"
                            >
                                Add in tracked
                            </button>
                        </div>
                    </li>
                </template>
            </ul>
        </template>
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
        },
        trackedCurrencies: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            details: [],
            detailsIsShow: false,
            value: '',
        }
    },
    created() {
        this.debouncedHandler = debounce(event => {
            const searchStr = event.target.value;

            const queryParams = {
                search: event.target.value,
            };

            getCurrencies(queryParams)
                .then((res) => {
                    this.details = res.data;
                });

        }, 700);
    },
    beforeUnmount() {
        this.debouncedHandler.cancel();
    },
    methods: {
        onFocus() {
            getCurrencies()
                .then((res) => {
                    this.details = res.data;
                });

            this.detailsIsShow = true;
        },
        isTracked(currencyName) {
            return this.trackedCurrencies.includes(currencyName);
        },
        addInTracked(name) {
            postTrackedCurrencies([name])
                .then(res => {
                    if (res.status === 200) {
                        this.$emit('addTracked', name);
                    }
                })
        },
        removeFromTracked(name) {

        }
    },
    computed: {}
}
</script>

