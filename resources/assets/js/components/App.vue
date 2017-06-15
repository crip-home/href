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
     * Called synchronously after the instance is created. At this stage, the
     * instance has finished processing the options which means the following
     * have been set up: data observation, computed properties, methods,
     * watch/event callbacks. However, the mounting phase has not been started,
     * and the $el property will not be available yet.
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
