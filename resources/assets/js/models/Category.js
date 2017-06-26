import Audit from './Audit'

export default class Category {
  constructor ({
                id, title,
                created_at, created_by, created_by_name,
                updated_at, updated_by, updated_by_name
              }) {
    Object.assign(this, {id, title})

    this.audit = new Audit({
      created_at,
      created_by,
      created_by_name,
      updated_at,
      updated_by,
      updated_by_name
    })

    this.$editMode = false
  }
}
