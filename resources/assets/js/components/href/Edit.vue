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
              v-model="form.url" @blur="urlChanged"
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
        <button class="btn btn-danger" @click.prevent="closeModal"
                title="Dismiss">
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
  import FormGroup from '../forms/FormGroup.vue'
  import Href from '../../models/Href'
  import axios from 'axios'
  import config from '../../config'

  export default {
    name: 'href-edit',

    async created () {
      if (this.isEdit) {
        this.form = await this.$api.href.find(this.id)
      }

      this.categories = await this.$api.category.all()

      if (this.form.category_id) {
        this.form.category = this.categories.find(
          category => category.id === this.form.category_id
        )
      }
    },

    components: {FormGroup},

    computed: {
      /**
       * Gets title for the modal depending on route parameter.
       * @return {String}
       */
      title () {
        if (this.isEdit) {
          return 'Update changes'
        }

        return 'Create new record'
      },

      /**
       * Determines is the modal open for edit record.
       * @return {boolean}
       */
      isEdit () {
        return this.$route.name === routes.hrefEdit.name
      },

      /**
       * Gets parent identifier.
       * @return {number}
       */
      parentId () {
        return parseInt(this.$route.params.page || 0)
      },

      /**
       * Gets identifier if modal is open for edit.
       * @return {number}
       */
      id () {
        return parseInt(this.$route.params.href || 0)
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
        this.$router.push({...routes.hrefs, page: this.parentId})
      },

      /**
       * Create or update record using server API
       * @return {Promise.<void>}
       */
      async save () {
        try {
          let record = new Href({
            ...this.form,
            id: this.id,
            parent_id: this.parentId
          })

          let saved = await this.$api.href.save(record)
          this.$emit('saved', saved)
          this.closeModal()
        } catch (validationError) {
          this.errors = validationError.errors
        }
      },

      urlChanged () {
        if (!this.form.title && this.form.url) {
          let uri = `${config.apiUrl}/href/title?` +
            `url=${encodeURIComponent(this.form.url)}`

          axios.get(uri)
            .then(({data: {title}}) => {
              if (title) {
                this.form.title = title
              }
            })
        }
      }
    }
  }
</script>
