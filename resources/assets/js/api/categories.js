import axios from 'axios'
import config from '../config'
import Category from '../models/Category'
import {handleError} from '../errors'

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
      const records = response.data.map(item => new Category(item))
      config.log('api.categories.all()', records)

      return records
    } catch (ex) {
      handleError(ex)
    }
  }
}
