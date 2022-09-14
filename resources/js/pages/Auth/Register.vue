<template>
    <div class="form">
        <custom-input value="dff" type="email" label="Email"/>
    </div>
</template>

<script>
import CustomInput from '../../components/UI/Input.vue';

export default {
    name: 'Register',
    components: {
        CustomInput,
    },
}
</script>
