import href from './hrefs'
import category from './categories'

export default {
  install (Vue) {
    // inject api objects to Vue instance
    Vue.prototype.$api = {
      category, href
    }
  }
}
