import axios from 'axios'
import config from '../config'

export default {
  get (parentId = 0) {
    return new Promise((resolve, reject) => {
      axios.get(`${config.apiUrl}/href`)
        .then(response => {
          // TODO: map entries to models
          resolve(response)
        })
        .catch(err => {
          // TODO:add global error handler for the server errors
          console.error(err)
        })
    })
  }
}
