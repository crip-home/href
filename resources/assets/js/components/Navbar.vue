<template>
  <li>
    <a @click="logout" href="/logout">
      Logout
    </a>

    <form id="logout-form"
          action="/logout"
          method="POST">
      <input type="hidden" name="_token" :value="csrf">
    </form>
  </li>
</template>

<script>
  import config from '../config'

  export default {
    name: 'navbar',

    data () {
      return {
        csrf: config.token
      }
    },

    methods: {
      logout (event) {
        event.preventDefault()
        document.getElementById('logout-form').submit()
      },

      toggle () {
        this.isOpen = !this.isOpen
      }
    }
  }
</script>

<style>
  #logout-form {
    display: none;
  }
</style>
