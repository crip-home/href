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
      let response = await axios.get(`${this.url}/list/${parentId}`)

      return response.data.map(href => new Href(href))
    } catch (ex) {
      handleError(ex)
    }
  },

  /**
   * Find single record instance on server api.
   * @param {number} id
   * @return {Promise.<Href>}
   */
  async find (id) {
    try {
      let url = `${this.url}/${id}`
      let response = await axios.get(url)

      return new Href(response.data)
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

      if (!response.data) {
        throw response
      }

      return new Href(response.data)
    } catch (ex) {
      if (ex.response.status === 422) {
        throw new ValidationError(ex.response.data)
      }

      handleError(ex)
      throw new Error('Unknown error')
    }
  }
}
