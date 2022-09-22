<template>
    <div class="flex items-start mb-4">
        <div class="flex items-center h-5">
            <input :id="name"
                   type="checkbox"
                   value=""
                   class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                   required
            >
        </div>
        <label
            :for="name"
            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
        >
            <slot></slot>
        </label>
    </div>
</template>

<script>
export default {
    name: 'CustomCheckbox',
    props: {
        name: {
            type: String,
            required: true,
        },
    },
    methods: {},
}
</script>
