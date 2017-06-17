const token = document.head.querySelector('meta[name="csrf-token"]')
const apiUrl = document.head.querySelector('meta[name="api-url"]')
const userToken = document.head.querySelector('meta[name="user-token"]')

const getContent = (el) => el ? el.content : ''

export default {
  debug: true,
  token: getContent(token),
  apiUrl: getContent(apiUrl),
  userToken: getContent(userToken),
  log (...args) {
    if (this.debug) {
      console.log.apply(console, args)
    }
  }
}
