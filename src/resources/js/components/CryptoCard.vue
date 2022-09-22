<template>
    <div>
        <input
            type="checkbox"
            @change="handleChecked"
            :value="name"
            :id="getId"
            :name="name"
            class="hidden peer"
        >
        <label :for="getId"
               class="flex flex-col cursor-pointer items-end justify-end sm:rounded-lg h-48 p-6 pb-2 text-white bg-no-repeat border-b-8 border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
               :style="{'background-image': 'url('+ getImageUrl +')'}"
               style="background-size: 6rem; background-position: 1rem 1rem;"
        >
            <h3 class="text-3xl font-bold">{{ getTitle }}</h3>
            <span class="text-2xl">{{ getPrice }}</span>
        </label>
    </div>
</template>

<script>
export default {
    name: 'CryptoCard',
    props: {
        name: {
            type: String,
            required: true,
        },
        price: {
            type: String,
            default: 0.00,
        },
        image: {
            type: String,
            required: true,
        },
    },
    data() {
        return {}
    },
    computed: {
        getId() {
            return `${this.name}--option`;
        },
        getTitle() {
            return this.name.toUpperCase();
        },
        getPrice() {
            const price = parseInt(this.price);

            return `${this.price}$`;
        },
        getImageUrl() {
            return `https://www.cryptocompare.com/media/${this.image}`;
        },
    },
    methods: {
        handleChecked() {
            const isChecked = event.target.checked;

            if (isChecked) {
                this.$emit('setCurrency', event.target.value);
            } else {
                this.$emit('removeCurrency', event.target.value);
            }
        },
    }
}
</script>
