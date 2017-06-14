<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
  import * as routes from '../router/routes'

  export default {
    /**
     * The name of component.
     */
    name: 'app',

    /**
     * In the created hook, you will be able to access reactive data and events
     * are active. Templates and Virtual DOM have not yet been mounted or
     * rendered. The most frequently used patterns are fetching data for your
     * component.
     */
    created () {
      this.$emit('app:created')
    },

    data () {
      return {
        edit: routes.hrefEdit
      }
    }
  }
</script>
