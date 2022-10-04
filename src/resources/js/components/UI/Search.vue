<template>
    <div class="relative w-1/3"
         @focusin="detailsIsShow = true"
         v-click-out-side="clickOutside"
    >
        <input
            class="w-full rounded-lg focus:border-transparent focus:border-solid focus:border-b focus:border-stone-500 focus:ring-0"
            type="text"
            name="search"
            @input="debouncedHandler"
            id="search"
        />
        <template v-if="detailsIsShow && details.at(-1)">
            <ul
                class="absolute max-h-52 overflow-y-auto bg-white w-full rounded-b-lg p-2"
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
                                @click="removeFromTracked(detail.name)"
                            >
                                Remove from tracked
                            </button>
                            <button
                                v-else
                                class="text-green-700"
                                @click="addInTracked(detail.name)"
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
import clickOutSide from "../../directives/clickOutSide.js";

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

            if (searchStr) {
                getCurrencies(queryParams)
                    .then((res) => {
                        this.details = res.data;
                    });
            } else {
                this.details = [];
            }
        }, 700);
    },
    beforeUnmount() {
        this.debouncedHandler.cancel();
    },
    directives: {
        clickOutSide,
    },
    methods: {
        isTracked(currencyName) {
            return this.trackedCurrencies.includes(currencyName);
        },
        addInTracked(currencyName) {
            this.$emit('addTracked', currencyName);
        },
        removeFromTracked(currencyName){
            this.$emit('removeTracked', currencyName);
        },
        clickOutside() {
            this.detailsIsShow = false;
        }
    },
}

</script>

