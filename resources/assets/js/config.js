const token = document.head.querySelector('meta[name="csrf-token"]').content
const apiUrl = document.head.querySelector('meta[name="api-url"]').content

export default {
  token,
  apiUrl
}
