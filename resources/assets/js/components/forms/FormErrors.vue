<template>
  <ul class="help-block" v-if="hasErrors">
    <li v-for="error in errors" class="text-danger">{{ error }}</li>
  </ul>
</template>

<script>
  export default {
    name: 'form-errors',

    props: {
      /**
       * Collection of errors to show.
       * @type {{type: (Array|ArrayConstructor), default: (function(*): Array)}}
       */
      errors: {type: Array, 'default': _ => []}
    },

    computed: {
      /**
       * Determines is there errors in a collection.
       * @return {boolean}
       */
      hasErrors () {
        return this.errors && this.errors.length > 0
      }
    }
  }
</script>
