import axios from 'axios'
import config from '../config'
import Href from '../models/Href'

export default {
  /**
   * Fetch hrefs from server api.
   * @param [parentId]
   * @return {Promise.<Array.<Href>>}
   */
  async get (parentId = 0) {
    try {
      let response = await axios.get(`${config.apiUrl}/href`)
      return response.data.reduce((prew, curr) => {
        return [...prew, new Href(curr)]
      }, [])
    } catch (ex) {
      // TODO:add global error handler for the server errors
      console.error(ex)
    }
  }
}
