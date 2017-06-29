import categories from './categories'
import hrefs from './hrefs'
import tags from './tags'

export default {
  install (Vue) {
    // inject api objects to Vue instance
    Vue.prototype.$api = {
      categories, hrefs, tags
    }
  }
}
