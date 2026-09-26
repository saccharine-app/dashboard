import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import '../css/dashboard.css';

const el = document.getElementById('saccharine-dashboard-root');

if (el) {
  const pinia = createPinia();
  const app = createApp(App);

  app.use(pinia);
  app.mount(el);
}