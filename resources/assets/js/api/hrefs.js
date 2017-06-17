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
   * Save gref record on server api.
   * @param {Href} record
   * @param {Number} parentId
   * @param {Number} id
   * @return {Promise.<Href>}
   */
  async save (record, parentId = 0, id = 0) {
    try {
      record.category_id = record.category ? record.category.id : null
      if (parentId > 0) {
        record.parent_id = parentId
      }

      let url = id > 0 ? `${this.url}/${id}` : this.url
      let method = id > 0 ? 'put' : 'post'
      let response = await axios[method](url, record)
      let output = new Href(response.data)

      config.log('api.hrefs.save()', {record, parentId, id}, output)

      return output
    } catch (ex) {
      if (ex.response.status === 422) {
        config.log(
          `api.hrefs.save()`, {record, parentId, id}, 'validation failed',
          ex.response.data
        )
        throw new ValidationError(ex.response.data)
      }

      handleError(ex)
      throw new Error('Unknown error')
    }
  }
}
