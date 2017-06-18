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
      let records = response.data.map(href => new Href(href))
      config.log(`api.hrefs.get()`, {parentId}, records)

      return records
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
      let record = new Href(response.data)
      config.log(`api.hrefs.find()`, {id}, record)

      return record
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
      if (ex.response.status === 422) {
        config.log(
          `api.hrefs.save()`, {record}, 'validation failed',
          ex.response.data
        )
        throw new ValidationError(ex.response.data)
      }

      handleError(ex)
      throw new Error('Unknown error')
    }
  }
}
