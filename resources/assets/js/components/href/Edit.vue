<template>
  <div class="href-edit">
    <crip-modal @hidden="modalHidden" :close="close">
      <span slot="title">Modal Title</span>

      <div class="modal-body">
        Content should be here
        <button class="btn btn-danger" @click="closeModal">&times;</button>
      </div>
    </crip-modal>
  </div>
</template>

<script>
  import * as routes from '../../router/routes'

  export default {
    name: 'href-edit',
    data () {
      return {
        // open modal by default while it is mounting
        close: false
      }
    },

    methods: {
      closeModal () {
        this.close = true
      },

      modalHidden () {
        // Go to parent route when modal is hidden
        this.$router.push({...routes.hrefs, page: this.$route.params.page || 0})
      }
    }
  }
</script>
