<template>
  <div class="href-list row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <span class="panel-title">People shared hrefs</span>
        <span class="panel-action pull-right">
          <router-link :to="createNewRoute" class="btn btn-sm btn-primary">
            Add
          </router-link>
        </span>
      </div>

      <table class="table table-hover">
        <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Url</th>
          <th>Category</th>
        </tr>
        </thead>
        <tbody>
        <router-link
            v-for="item in items"
            :key="item.id"
            :to="item.route"
            tag="tr"
            class="pointee"
        >
          <template>
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

    <router-view @saved="listRecordSaved"></router-view>

  </div>
</template>

<script>
  import api from '../../api/hrefs'
  import * as routes from '../../router/routes'

  export default {
    name: 'href-list',

    created () {
      this.$emit('href-list:created')
      this.fetchItems(this.currentPage)
    },

    computed: {
      /**
       * Gets current page identifier.
       * @return {number}
       */
      currentPage () {
        return this.$route.params.page || 0
      },

      /**
       * Gets current page create route object.
       * @return {{page: computed.currentPage}}
       */
      createNewRoute () {
        return {...routes.hrefCreate, page: this.currentPage}
      }
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
      },

      listRecordSaved (record) {
        let exists = this.items.find(item => item.id === record.id)
        if (exists) {
          return Object.assign(exists, record)
        }

        this.items.push(record)
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

  .pointee {
    cursor: pointer;
  }
</style>
