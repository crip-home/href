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
          <th></th>
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
            <td class="table-wide">
              {{ item.title }}&nbsp;
            </td>
            <td class="table-wide">{{ item.url }}</td>
            <td>{{ item.category ? item.category.title : '' }}</td>
            <td>
              <router-link
                  :to="item.editRoute" class="label label-info actions"
              >
                Edit
              </router-link>
            </td>
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
  import * as routes from '../../router/routes'

  export default {
    name: 'href-list',

    created () {
      this.$emit('href-list:created')
      this.fetchItems()
    },

    computed: {
      /**
       * Gets current page identifier.
       * @return {Number}
       */
      currentPage () {
        return parseInt(this.$route.params.page || 0)
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
       * @return {Promise.<void>}
       */
      async fetchItems () {
        this.items = await this.$api.href.get(this.currentPage)
      },

      /**
       * Listen event of record saved.
       * @param record
       * @return {*}
       */
      listRecordSaved (record) {
        if (record.parent_id !== this.currentPage) return

        let exists = this.items.find(item => item.id === record.id)
        if (exists) {
          return Object.assign(exists, record)
        }

        this.items.push(record)
      }
    },

    watch: {
      async currentPage () {
        await this.fetchItems()
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
