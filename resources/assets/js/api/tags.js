import axios from 'axios'
import config from '../config'
import Tag from '../models/Tag'
import {handleError} from '../errors'

export default {

  /**
   * Root url of the api module.
   * @type {string}
   */
  url: `${config.apiUrl}/tag`,

  /**
   * Fetch all tags from server api for a page.
   * @param  {Number} pageId
   * @return {Promise.<Array<Tag>>}
   */
  async all (pageId) {
    try {
      let response = await axios.get(`${this.url}/all/${pageId}`)

      return response.data.map(item => new Tag(item))
    } catch (ex) {
      handleError(ex)
    }
  }
}
