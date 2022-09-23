<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg bg-gray-100">
            <div class="flex items-baseline mb-4 font-mono font-extrabold">
                <h1 class="text-3xl">Login/</h1>
                <router-link
                    class="text-2xl underline text-gray-600 hover:text-gray-900"
                    to="register">
                    Register
                </router-link>
            </div>
            <form @submit.prevent="handleSubmit">
                <p v-if="errors.unauthorized"
                   class="my-2 text-sm text-red-600 dark:text-red-500">
                    'There is no user with this username and password'
                </p>
                <custom-input v-model="formData.email" :errors="errors.email" lable="Email" name="email" type="email"/>
                <custom-input v-model="formData.password" :errors="errors.password" lable="Password" name="password"
                              type="password"/>
                <button
                    type="submit"
                    class="p-2 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import CustomInput from '../../components/UI/Input.vue';
import CustomCheckbox from '../../components/UI/Checkbox.vue';

import {login} from "../../axios/auth";

export default {
    components: {
        CustomInput,
        CustomCheckbox,
    },
    data() {
        return {
            formData: {
                email: '',
                password: '',
            },
            errors: {},
        }
    },
    methods: {
        handleSubmit() {
            login(
                this.formData.email,
                this.formData.password
            ).then((res) => {
                    const user = res.data.user;

                    localStorage.setItem('user', JSON.stringify(user));
                    localStorage.setItem('token', JSON.stringify(res.data.authorization));

                    if (localStorage.getItem('token')) {
                        if (user.first_login) {
                            this.$router.push({name: 'preferences'});
                        } else {
                            this.$router.push({name: 'home'});
                        }
                    }
                },
                (errs) => {
                    const res = errs.response;

                    switch (res.status) {
                        case 422:
                            this.errors = res.data.errors;
                            break;
                        case 401 :
                            this.errors = {
                                'unauthorized': true
                            };
                            break;
                    }
                }
            )
        }
    }
}
</script>
