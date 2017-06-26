import axios from 'axios'
import config from '../config'
import Category from '../models/Category'
import {handleError} from '../errors'
import ValidationError from '../errors/ValidationError'

export default {

  /**
   * Root url of the api module.
   * @type {string}
   */
  url: `${config.apiUrl}/category`,

  /**
   * Fetch all categories from server api.
   * @return {Promise.<Array.<Category>>}
   */
  async all () {
    try {
      let response = await axios.get(this.url)

      return response.data.map(item => new Category(item))
    } catch (ex) {
      handleError(ex)
    }
  },

  /**
   * Create or update category on server api.
   * @param {Category} record
   * @return {Promise.<Category>}
   */
  async save (record) {
    try {
      let url = record.id > 0 ? `${this.url}/${record.id}` : this.url
      let method = record.id > 0 ? 'put' : 'post'
      let response = await axios[method](url, record)

      return new Category(response.data)
    } catch (ex) {
      if (ex.response.status === 422) {
        throw new ValidationError(ex.response.data)
      }

      handleError(ex)
      throw new Error('Unknown error')
    }
  }
}
