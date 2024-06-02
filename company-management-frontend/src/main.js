import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import apiClient from "./api";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

const app = createApp(App);

app.config.globalProperties.$apiClient = apiClient;

app.use(router).mount("#app");
