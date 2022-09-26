<template>
    <h1>dsd</h1>
</template>

<script>
import {logout} from "../../axios/auth.js";

export default {
    mounted() {
        logout().then((res) => {
            if (res.status === 200) {
                localStorage.clear();
                this.$router.push({name: 'login'});
            } else {
                this.$router.back();
            }
        });
    },
}
</script>
