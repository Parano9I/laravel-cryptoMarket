<template>
    <div class="mb-4">
        <label
            :for="name"
            class="block mb-2 text-sm font-medium text-gray-900"
        >
            {{ lable }}
        </label>
        <input
            :value="modelValue"
            @input="updateValue"
            :type="type"
            :id="name"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            :required="required"
        >
        <p
            v-for="error in errors"
            class="mt-2 text-sm text-red-600 dark:text-red-500">
            {{ error }}
        </p>
    </div>
</template>
<script>
export default {
    name: 'CustomInput',
    props: {
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        lable: {
            type: String,
            required: true,
        },
        required: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            type: [String, Number],
            default: '',
        },
        errors: {
            type: Array,
            default: []
        }
    },
    methods: {
        updateValue() {
            this.$emit('update:modelValue', event.target.value);
        }
    },
}
</script>
