<template>
  <div class="category-list panel panel-primary">
    <div class="panel-heading">
      <span class="panel-title">Categories</span>
    </div>

    <table class="table table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>Category</th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="category in categories"
          :key="category.id"
          @dblclick="editMode($event, category)"
      >
        <td>{{ category.id }}</td>
        <td v-if="!category.$editMode">{{ category.title }}</td>
        <td v-else>
          <form class="form-inline" @submit.prevent="save($event, category)">
            <form-group :errors="errors" :controlClass="''">
              <input
                  type="text"
                  v-model="category.title"
                  class="form-control"
                  title="Category title"
              />
            </form-group>
          </form>
        </td>
      </tr>
      </tbody>
    </table>

    <div class="panel-body">
      <button @click="addNewCategory" class="btn btn-primary">
        Add new category
      </button>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Category from '../../models/Category'
  import FormGroup from '../forms/FormGroup.vue'

  export default {
    name: 'category-list',

    components: {FormGroup},

    async created () {
      await this.fetchCategories()
    },

    data () {
      return {
        categories: [],
        errors: []
      }
    },

    methods: {
      /**
       * Fetch categories from server api.
       * @return {Promise.<void>}
       */
      async fetchCategories () {
        this.categories = await this.$api.category.all()
      },

      /**
       * Enable edit mode for the category record.
       * @param {Event} e
       * @param {Category} category
       */
      editMode (e, category) {
        // disable edit mode for all categories.
        this.categories.forEach(cat => {
          cat.$editMode = false
        })

        // enable for current instance
        category.$editMode = true

        // focus input only when it becomes visible on UI
        Vue.nextTick(
          () => this.$el.getElementsByTagName('input')[0].focus()
        )
      },

      /**
       * Save category in server api.
       * @param  {Event} e
       * @param  {Category} category
       * @return {Promise.<void>}
       */
      async save (e, category) {
        try {
          let newRecord = await this.$api.category.save(category)
          let oldCat = this.categories.find(cat => cat.id === newRecord.id)

          if (oldCat) {
            oldCat.title = newRecord.title
            category.$editMode = false
            return
          }

          // remove cat 0 witch is for create
          this.categories.splice(
            this.categories.indexOf(
              this.categeries.find(cat => cat.id === 0)
            ), 1
          )

          this.categories.push(newRecord)
        } catch (validation) {
          this.errors = validation.errors
        }
      },

      /**
       * Add new category to list with enabled edit mode.
       */
      addNewCategory () {
        let cat = new Category({title: '', id: 0})
        this.categories.push(cat)
        this.editMode(null, cat)
      }
    }
  }
</script>
