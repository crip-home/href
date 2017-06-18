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

      return response.data.map(item => new Category(item))
    } catch (ex) {
      handleError(ex)
    }
  }
}
