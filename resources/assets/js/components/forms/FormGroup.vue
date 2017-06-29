<template>
  <div class="form-group" :class="{'has-error': hasErrors}">
    <label
        class="control-label"
        :for="target"
        :id="`${target}-label`"
        :class="labelClass"
        v-if="label"
    >
      {{ label }}
    </label>
    <div :class="controlClass">
      <slot></slot>
      <form-errors :errors="errors"></form-errors>
    </div>
  </div>
</template>

<script>
  import FormErrors from './FormErrors.vue'

  export default {
    name: 'form-group',

    components: {FormErrors},

    props: {
      target: {type: String, default: () => ''},
      label: {type: String, default: () => ''},
      errors: {type: Array, default: () => null},
      labelClass: {type: String, default: () => 'col-md-3 col-sm-4'},
      controlClass: {type: String, default: () => 'col-sm-8'}
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
