import Vue from 'vue'
import Router from 'vue-router'
import * as routeNames from './routes'
import CategoryList from '../components/categories/List.vue'
import HrefDetails from '../components/href/Details.vue'
import HrefEdit from '../components/href/Edit.vue'
import HrefList from '../components/href/List.vue'

Vue.use(Router)

const routes = [
  {
    name: routeNames.hrefs.name,
    path: '/hrefs/:page(\\d+)',
    component: HrefList,
    children: [
      {
        ...routeNames.hrefDetails,
        path: 'details/:href(\\d+)',
        component: HrefDetails
      },
      {
        ...routeNames.hrefEdit,
        path: 'edit/:href(\\d+)',
        component: HrefEdit
      },
      {
        ...routeNames.hrefCreate,
        path: 'create',
        component: HrefEdit
      }
    ]
  }, {
    ...routeNames.categories,
    path: '/categories',
    component: CategoryList
  }, {
    path: '*', redirect: '/hrefs/0'
  }
]

let router = new Router({
  scrollBehavior: () => ({y: 0}),
  routes
})

export default router
