<template>
  <div class="form-group" :class="{'has-error': !!errors}">
    <label
        class="control-label"
        :for="target"
        :id="`${target}-label`"
        :class="labelClass"
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
      labelClass: {type: String, default: () => 'col-lg-3 col-md-4 col-ms-5'},
      controlClass: {type: String, default: () => 'col-lg-8 col-md-7'}
    }
  }
</script>
