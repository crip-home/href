import axios from 'axios'
import config from '../config'
import Href from '../models/Href'
import {handleError} from '../errors'
import ValidationError from '../errors/ValidationError'

export default {

  /**
   * Root url of the api module.
   * @type {string}
   */
  url: `${config.apiUrl}/href`,

  /**
   * Fetch hrefs from server api.
   * @param [parentId]
   * @return {Promise.<Array.<Href>>}
   */
  async get (parentId = 0) {
    try {
      let url = parentId > 0 ? `${this.url}/${parentId}` : this.url
      let response = await axios.get(url)

      return response.data.map(href => new Href(href))
    } catch (ex) {
      handleError(ex)
    }
  },

  /**
   * Save gref record on server api.
   * @param {Href} record
   * @return {Promise.<Href>}
   */
  async save (record) {
    try {
      let url = record.id > 0 ? `${this.url}/${record.id}` : this.url
      let method = record.id > 0 ? 'put' : 'post'
      let response = await axios[method](url, record)

      return new Href(response.data)
    } catch (ex) {
      if (ex.status === 422) {
        throw new ValidationError(ex.data)
      }

      handleError(ex)
      throw new Error('Unknown error')
    }
  }
}
