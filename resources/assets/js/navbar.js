import Vue from 'vue'
import Navbar from './components/Navbar.vue'

const navbar = new Vue({
  render: h => h(Navbar)
})

if (document.getElementById('navbar')) {
  navbar.$mount('#navbar')
}
