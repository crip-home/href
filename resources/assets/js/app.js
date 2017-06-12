import Vue from 'vue'
import App from './components/App.vue'
import axios from 'axios'
import router from './router'
import config from './config'
import './../sass/app.scss'

axios.defaults.headers.common['X-CSRF-TOKEN'] = config.token

let app = new Vue(Vue.util.extend({
  router
}, App))

app.$mount('#app')
