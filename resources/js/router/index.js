import { createRouter, createWebHistory } from "vue-router";

import Welcome from "../components/Welcome.vue";
import Advertise from "../components/Advertise.vue";
import Guide from "../components/Guide.vue";
import Login from "../components/Login.vue";
import Detail from "../components/Detail.vue";
import Home from "../components/Home.vue";
import Dashboard from "../components/Dashboard.vue";
import AdminDetail from "../components/adminDetail.vue";

import store from "../store";

const routes = [
    {
        path: "/",
        name: "welcome",
        component: Welcome,
    },
    {
        path: "/advertise",
        name: "advertise",
        component: Advertise,
    },
    {
        path: "/guide",
        name: "guide",
        component: Guide,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/detail/:id",
        name: "detail",
        component: Detail
    },
    {
        path: "/home",
        name: "home",
        component: Home,
        redirect: {
            name: "dashboard",
        },
        meta: {
            guard: "auth",
        },
        children: [
            {
                path: "/dashboard",
                name: "dashboard",
                component: Dashboard,
                meta: {
                    guard: "auth"
                }
            },
            {
                path: "/adminDetail/:id",
                name: "adminDetail",
                component: AdminDetail,
                meta: {
                    guard: "auth"
                }
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (store.getters.user) {
        if (to.matched.some((route) => route.meta.guard === "guest"))
            next({ name: "home" });
        else next();
    } else {
        if (to.matched.some((route) => route.meta.guard === "auth"))
            next({ name: "login" });
        else next();
    }
});

export default router;
