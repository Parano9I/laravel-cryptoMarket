// import './bootstrap';
import {createApp} from "vue/dist/vue.esm-bundler.js";
import App from './App.vue';
import router  from "./router";

const app = createApp({
    components: {
        App,
    },
});

app.mount('#app');
app.use(router);
