export default class ValidationError extends Error {
  constructor (errors = [], message = '', id = undefined) {
    super(message, id)
    this.errors = errors
  }
}
