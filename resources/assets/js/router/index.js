import Vue from 'vue'
import Router from 'vue-router'

import * as routes from './routes'

import HrefList from '../components/href/List.vue'
import HrefDetails from '../components/href/Details.vue'
import HrefEdit from '../components/href/Edit.vue'

Vue.use(Router)

export default new Router({
  scrollBehavior: () => ({y: 0}),
  routes: [
    {
      path: '/', redirect: '/hrefs'
    },
    {
      ...routes.hrefs,
      path: '/hrefs/:page(\\d+)',
      component: HrefList,
      children: [
        {
          ...routes.hrefDetails,
          path: 'details/:href(\\d+)',
          component: HrefDetails
        },
        {
          ...routes.hrefEdit,
          path: 'edit/:href(\\d+)',
          component: HrefEdit
        },
        {
          ...routes.hrefCreate,
          path: 'create',
          component: HrefEdit
        }
      ]
    }
  ]
})
