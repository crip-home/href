const token = document.head.querySelector('meta[name="csrf-token"]').content
const apiUrl = document.head.querySelector('meta[name="api-url"]').content
const userToken = document.head.querySelector('meta[name="user-token"]').content

export default {
  token,
  apiUrl,
  userToken
}
