<template>
  <form class="form-horizontal href-edit" @submit.prevent="save">
    <crip-modal @hidden="modalHidden" :close="close" size="lg">
      <span slot="title">{{ title }}</span>

      <div class="modal-body">
        <!-- TODO: add associated tags list here. -->
        <form-group target="title" :errors="errors.title" label="Title">
          <input
              type="text" class="form-control" name="title" id="title"
              v-model="form.title"
          />
        </form-group>

        <form-group target="url" :errors="errors.url" label="URL">
          <input
              type="text" class="form-control" name="url" id="url"
              v-model="form.url"
          />
        </form-group>

        <form-group
            target="category" :errors="errors.category" label="Category"
        >
          <select
              v-model="form.category" name="category" id="category"
              class="form-control"
          >
            <option value="" selected></option>
            <option v-for="category in categories" :value="category">
              {{ category.title }}
            </option>
          </select>
        </form-group>

        <form-group target="visible" :errors="errors.visible">
          <label title="Change visibility">
            <input type="checkbox" name="visible" v-model="form.visible">
            &nbsp;Visibility
          </label>
        </form-group>
      </div>

      <div class="modal-footer">
        <button class="btn btn-danger" @click="closeModal" title="Dismiss">
          <span class="glyphicon glyphicon-remove"></span>
        </button>

        <button type="submit" class="btn btn-primary" value="Save" title="Save">
          <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save
        </button>
      </div>
    </crip-modal>
  </form>
</template>

<script>
  import * as routes from '../../router/routes'
  import categoriesApi from '../../api/categories'
  import hrefsApi from '../../api/hrefs'
  import FormGroup from '../forms/FormGroup.vue'
  import Href from '../../models/Href'

  export default {
    name: 'href-edit',

    async created () {
      this.categories = await categoriesApi.all()
    },

    components: {FormGroup},

    computed: {
      /**
       * Gets title for the modal depending on route parameter.
       * @return {String}
       */
      title () {
        if (this.$route.name === routes.hrefCreate.name) {
          return 'Create new record'
        }

        return 'Update changes'
      }
    },

    data () {
      return {
        // open modal by default while it is mounting
        close: false,
        categories: [],
        errors: {},
        form: {
          title: '',
          url: '',
          visible: true,
          category: null
        }
      }
    },

    methods: {
      closeModal () {
        this.close = true
      },

      modalHidden () {
        // Go to parent route when modal is hidden
        this.$router.push({...routes.hrefs, page: this.$route.params.page || 0})
      },

      /**
       * Create or update record using server API
       */
      async save () {
        try {
          let record = new Href(this.form)
          let parent = this.$route.params.page
          let id = this.$route.params.id

          let saved = await hrefsApi.save(record, parent, id)
          this.$emit('saved', saved)
          this.closeModal()
        } catch (validationError) {
          this.errors = validationError.errors
        }
      }
    }
  }
</script>
