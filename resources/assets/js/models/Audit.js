export default class Audit {
  constructor ({
                created_at, created_by, created_by_name,
                updated_at, updated_by, updated_by_name
              }) {
    this.created = {at: created_at, by: created_by, name: created_by_name}
    this.updated = {at: updated_at, by: updated_by, name: updated_by_name}
  }
}
