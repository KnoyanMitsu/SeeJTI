import { createApp } from 'vue'
import App from './App.vue'
import './assets/style.css'
import router from './router'
import { VsxIcon } from "vue-iconsax";

const app = createApp(App);

app.use(router);
app.component("VsxIcon", VsxIcon);
app.mount('#app');
