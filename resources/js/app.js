import "./bootstrap";

import { createApp } from "vue";
import App from './components/App.vue';

import store from "./store/index";
import router from "./router/index";

const app = createApp(App)

app.use(router)
app.use(store)
app.mount('#app')