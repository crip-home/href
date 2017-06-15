import axios from 'axios'
import config from '../config'
import Href from '../models/Href'
import {handleError} from '../error'

export default {
  /**
   * Fetch hrefs from server api.
   * @param [parentId]
   * @return {Promise.<Array.<Href>>}
   */
  async get (parentId = 0) {
    try {
      let url = `${config.apiUrl}/href`
      if (parentId > 0) {
        url += `/${parentId}`
      }

      let response = await axios.get(url)
      return response.data.map(href => new Href(href))
    } catch (ex) {
      handleError(ex)
    }
  }
}
