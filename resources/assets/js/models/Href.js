import Tag from './Tag'
import User from './User'
import Audit from './Audit'
import Category from './Category'
import * as routes from '../router/routes'

export default class Href {
  constructor ({
                category = null, tags = [], user = null,
                date_added, id, index, parent_id, title, url, visible,
                created_at, created_by, created_by_name,
                updated_at, updated_by, updated_by_name
              }) {
    Object.assign(this, {date_added, id, index, parent_id, title, url, visible})

    this.category = category ? new Category(category) : null
    this.category_id = category ? category.id : null
    this.user = user ? new User(user) : null
    this.tags = tags.map(rec => new Tag(rec))

    this.audit = new Audit({
      created_at,
      created_by,
      created_by_name,
      updated_at,
      updated_by,
      updated_by_name
    })
  }

  get route () {
    if (this.url) {
      return {
        ...routes.hrefDetails,
        params: {page: this.parent_id, href: this.id}
      }
    }

    return {
      ...routes.hrefs,
      params: {page: this.id}
    }
  }

  get editRoute () {
    return {
      ...routes.hrefEdit,
      params: {page: this.parent_id, href: this.id}
    }
  }
}
