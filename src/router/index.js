import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/import",
    name: "Import",
    component: () =>
      import("../views/Import.vue")
  },
  {
    path: "/custom",
    name: "Custom",
    component: () =>
      import("../views/Custom.vue")
  },
  {
    path: "/find_key",
    name: "Utility",
    component: () =>
      import("../views/Utility.vue")
  },
  {
    path: "/export",
    name: "Export",
    component: () =>
      import("../views/Export.vue")
  },
  {
    path: "/view",
    name: "View",
    component: () =>
      import("../views/View.vue")
  },
  {
    path: "/view",
    name: "View",
    component: () =>
      import("../views/View.vue")
  },
  {
    path: "/edit",
    name: "Edit",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/Edit.vue")
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
