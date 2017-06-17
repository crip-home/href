<template>
  <ul class="help-block" v-if="errors">
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
    }
  }
</script>
