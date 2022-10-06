import axios from "axios";
import reLoginInterceptor from "./interceptors/reLoginInterceptor";
import router from "../route/index.js";

const httpClient = axios.create({
    baseURL: '/api',
    headers: {
        "Content-Type": "application/json",
    },
});

httpClient.interceptors.response.use(
    null,
    (http) => reLoginInterceptor(http.response, router)
);

export default httpClient;
