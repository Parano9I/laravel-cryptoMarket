<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg bg-gray-100">
            <div class="flex items-baseline mb-4 font-mono font-extrabold">
                <h1 class="text-3xl">Register/</h1>
                <router-link
                    class="text-2xl underline text-gray-600 hover:text-gray-900"
                    to="login">
                    Login
                </router-link>
            </div>
            <form @submit.prevent="handleSubmit">
                <custom-input v-model="formData.first_name" :errors="errors.first_name" lable="First name"
                              name="first_name"/>
                <custom-input v-model="formData.last_name" :errors="errors.last_name" lable="Last name"
                              name="last_name"/>
                <custom-input v-model="formData.email" :errors="errors.email" lable="Email" name="email" type="email"/>
                <custom-input v-model="formData.password" :errors="errors.password" lable="Password" name="password"
                              type="password"/>
                <custom-input v-model="formData.password_confirm" lable="Confirm password" name="password_confirmation"
                              type="password"/>
                <button type="submit"
                        class="p-2 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Register new account
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import CustomInput from '../../components/UI/Input.vue';
import CustomCheckbox from '../../components/UI/Checkbox.vue';

import {register} from "../../axios/auth";

export default {
    components: {
        CustomInput,
        CustomCheckbox,
    },
    data() {
        return {
            formData: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirm: '',
            },
            errors: {},
        }
    },
    methods: {
        handleSubmit() {
        register(
            this.formData
        ).then((res) => {
                localStorage.setItem('user', JSON.stringify(res.data.user));
                localStorage.setItem('token', JSON.stringify(res.data.authorization));

                if (localStorage.getItem('token')) {
                    this.$router.push({name: 'preferences'});
                }
            }).catch((errs) => {
                const res = errs.response;

                if (res.status === 422) {
                    this.errors = res.data.errors;
                }
            })
        }
    }
}
</script>
