import Vue from 'vue'
import VueRouter from 'vue-router'

import * as routes from './routes'

import HrefList from '../components/href/List.vue'
import HrefDetails from '../components/href/Details.vue'
import HrefEdit from '../components/href/Edit.vue'

Vue.use(VueRouter)

const routes = new VueRouter({
  scrollBehavior: () => ({y: 0}),
  routes: [
    {
      path: '/hrefs/:page(\\d+)', ...routes.hrefs, component: HrefList,
      children: [
        {path: 'details/:href(\\d+)', ...routes.hrefDetails, component: HrefDetails},
        {path: 'edit/:href(\\d+)', ...routes.hrefEdit, component: HrefEdit},
        {path: 'create', ...routes.hrefCreate, component: HrefEdit}
      ]
    }
})

export default routes
