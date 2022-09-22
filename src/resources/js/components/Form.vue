<template>
    <form @submit="handleSubmit">
        <custom-input v-model="first_name" lable="First name" name="first_name" required/>
        <custom-input value="sdssd" lable="Last name" name="last_name" required/>
        <custom-input lable="Email" name="email" type="email" required/>
        <custom-input lable="Password" name="password" type="password" required/>
        <custom-input lable="Confirm password" name="password" type="password" required/>
        <custom-checkbox name="comfirm">
            I agree with the
            <span class="text-blue-600 hover:underline dark:text-blue-500">
                        terms and conditions
                    </span>
        </custom-checkbox>
        <button type="submit"
                @click.prevent="logFields"
                class="p-2 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
            Register new account
        </button>
    </form>
</template>

<script>
import CustomInput from '../../components/UI/Input.vue';
import CustomCheckbox from '../../components/UI/Checkbox.vue';

import {ref} from 'vue';

export default {
    components: {
        CustomInput,
        CustomCheckbox,
    },
    setup() {
        const first_name = ref('');
    },
    methods: {
        logFields() {
            console.log(first_name.value);
        }
    }
}
</script>
