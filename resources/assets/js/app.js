import Vue from 'vue'
import App from './components/App.vue'
import axios from 'axios'
import router from './router'
import './../sass/app.scss'

let token = document.head.querySelector('meta[name="csrf-token"]')
axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content

let app = new Vue(Vue.util.extend({
  router
}, App))

app.$mount('#app')
