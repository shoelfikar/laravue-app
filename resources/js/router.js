import Vue from 'vue';
import Router from 'vue-router';
import Table from './views/Table.vue';
import AddBank from './views/AddBank.vue';
import EditBank from './views/EditBank.vue';

Vue.use(Router)


const routes = [
  {
    path: "/",
    name: 'Data Bank',
    component: Table
  },
  {
    path: "/addbank",
    name: 'Add Bank',
    component: AddBank
  },
  {
    path: "/editbank/:id",
    name: 'Edit Bank',
    component: EditBank,
    props: true
  }
]

const router = new Router({
  routes: routes
})


export default router;