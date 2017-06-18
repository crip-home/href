import Vue from 'vue'
import Modal from 'crip-vue-bootstrap-modal'
import App from './components/App.vue'
import axios from 'axios'
import router from './router'
import config from './config'
import Api from './api'
import './../sass/app.scss'

Vue.use(Modal)
Vue.use(Api)

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['X-CSRF-TOKEN'] = config.token
axios.defaults.headers.common['Authorization'] = `Bearer ${config.userToken}`

let app = new Vue(Vue.util.extend({
  router
}, App))

app.$mount('#app')
