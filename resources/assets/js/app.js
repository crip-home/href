import Vue from 'vue'
import App from './components/App.vue'
import axios from 'axios'
import router from './router'
import config from './config'
import './../sass/app.scss'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['X-CSRF-TOKEN'] = config.token
axios.defaults.headers.common['Authorization'] = `Bearer ${config.userToken}`

let app = new Vue(Vue.util.extend({
  router
}, App))

app.$mount('#app')
