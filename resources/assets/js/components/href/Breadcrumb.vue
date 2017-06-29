<template>
  <ol class="breadcrumb">
    <router-link :to="rootRoute" tag="li">
      <a>Root</a>
    </router-link>

    <router-link
        :to="item.route" v-for="item in items" :key="item.id" tag="li"
    >
      <a>{{ item.title }}</a>
    </router-link>
  </ol>
</template>

<script>
  import * as routes from '../../router/routes'

  export default {
    name: 'breadcrumb',

    async created () {
      this.items = await this.fetchData(this.page)
    },

    computed: {
      page () {
        return this.$route.params.page
      }
    },

    data () {
      return {
        rootRoute: {...routes.hrefs, params: {page: 0}},
        items: []
      }
    },

    methods: {
      async fetchData (page) {
        let result = []

        while (page > 0) {
          let curr = await this.$api.hrefs.find(page)
          page = curr.parent_id

          result.unshift(curr)
        }

        return result
      }
    },

    watch: {
      async page (page) {
        this.items = await this.fetchData(page)
      }
    }
  }
</script>

<style>
  .router-link-active {
    font-weight: bold;
  }

  .breadcrumb {
    margin-bottom: 0;
  }
</style>
