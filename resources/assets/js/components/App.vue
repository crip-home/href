<template>
  <div>
    <crip-loading color="rgb(13, 143, 243)"></crip-loading>
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

    /**
     * The data object for the Vue instance. Vue will recursively convert its
     * properties into getter/setters to make it “reactive”.
     * @return {{edit}}
     */
    data () {
      return {
        edit: routes.hrefEdit
      }
    }
  }
</script>
