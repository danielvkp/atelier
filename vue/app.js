import { createApp } from "vue";

import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

import { createVuetify } from "vuetify";
import { es } from "vuetify/locale";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

import App from "./main/Main.vue";

import { myCustomLightTheme } from "./theme/theme.js";

import { VCalendar } from "vuetify/labs/VCalendar";

import { VDateInput } from "vuetify/labs/VDateInput";

const vuetify = createVuetify({
    components: {
        components,
        VCalendar,
        VDateInput,
    },
    directives,
    defaults: {
        VBtn: {
            variant: "flat",
        },
        VTextField: {
            color: "blue",
            variant: "outlined",
            density: "compact",
        },
        VTextarea: {
            color: "blue",
            variant: "outlined",
            density: "compact",
        },
        VSelect: {
            color: "blue",
            variant: "outlined",
            density: "compact",
        },
    },
    theme: {
        defaultTheme: "myCustomLightTheme",
        themes: {
            myCustomLightTheme,
        },
    },
    locale: {
        locale: "es",
        fallback: "en",
        messages: { es },
    },
});

import axios from "axios";

window.axios = axios;

axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem("id_token")}`;
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "/api";

import setup from "./plugins/interceptors.js";
setup();

import Loader from "./componentes/globals/Loader.vue";
import VConfirm from "./componentes/globals/VConfirm.vue";
import eventBus from "./plugins/event-bus";

import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

import router from "./router/router.js";
import store from "./store/storage.js";

const app = createApp(App);
app.component("loader", Loader);
app.component("v-confirm", VConfirm);
app.component("QuillEditor", QuillEditor);
app.use(eventBus);
app.use(vuetify);
app.use(router);
app.use(store);
app.mount("#app");
