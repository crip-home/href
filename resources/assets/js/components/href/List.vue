<template>
  <div class="href-list row">
    <div class="panel panel-primary">
      <div class="panel-heading">People shared hrefs</div>

      <table class="table">
        <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Url</th>
          <th>Category</th>
        </tr>
        </thead>
        <tbody>
        <router-link v-for="item in items" :key="item.id" :to="item.route" tag="tr">
          <template class="pointee">
            <td>{{ item.id }}</td>
            <td class="table-wide">{{ item.title }}</td>
            <td class="table-wide">{{ item.url }}</td>
            <td>{{ item.category ? item.category.title : '' }}</td>
          </template>
        </router-link>
        </tbody>
      </table>

      <div class="panel-body bookmark-panel">

      </div>
    </div><!-- .panel -->

    <router-view></router-view>

  </div>
</template>

<script>
  import api from '../../api/hrefs'

  export default {
    name: 'href-list',

    created () {
      this.$emit('href-list:created')
      this.fetchItems(this.$route.params.page || 0)
    },

    data () {
      return {
        items: []
      }
    },

    methods: {
      /**
       * Set href records from api to component data object.
       * @param [parentId]
       * @return {Promise.<void>}
       */
      async fetchItems (parentId = 0) {
        this.items = await api.get(parentId)
      }
    }
  }
</script>

<style>
  .table-wide {
    max-width: 260px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>
