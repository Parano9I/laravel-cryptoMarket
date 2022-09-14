<template>
    <div class="input">
        <lable class="input__lable">
            {{ label }}
            <input class="input__field" :placeholder="label" :id="label" :type="type">
        </lable>
    </div>

</template>

<script>
export default {
    name: 'CustomInput',
    props: {
        label: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            required: true,
        },
        type: String,
    },
    data() {
        return {
            name: this.name,
            value: this.value
        }
    },
    computed: {
        type() {
            return this.type ? this.type : 'text';
        }
    }

}
</script>

<style lang="scss">
.input {

    &__lable {
    }
    & __field {
        border: 0;
    }
}
</style>
