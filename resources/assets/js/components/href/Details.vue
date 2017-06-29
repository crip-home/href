<template>
  <div class="href-details">
    <crip-modal @hidden="modalHidden" :close="close" size="lg">
      <span slot="title">{{ href.title }}</span>

      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item">
            Date added: {{ href.date_added }}
          </li>

          <li class="list-group-item">
            URL: {{ href.url }}
          </li>

          <li class="list-group-item">
            Visible: {{ href.visible ? 'Yes' : 'No' }}
          </li>

          <li class="list-group-item">
            Category: {{ href.category ? href.category.title : '' }}
          </li>

          <li class="list-group-item">
            Tags: <span v-for="tag in href.tags">{{ tag.tag }}&nbsp;</span>
          </li>
        </ul>
      </div>
    </crip-modal>
  </div>
</template>

<script>
  import * as routes from '../../router/routes'

  export default {
    name: 'href-details',

    async created () {
      this.href = await this.$api.hrefs.find(this.$route.params.href)
    },

    data () {
      return {
        // open modal by default while it is mounting
        close: false,
        href: {}
      }
    },

    methods: {
      modalHidden () {
        // Go to parent route when modal is hidden
        this.$router.push({...routes.hrefs, page: this.parentId})
      }
    }
  }
</script>

<style>
  .href-details .list-group {
    margin-bottom: 0;
  }
</style>
