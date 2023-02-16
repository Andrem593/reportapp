import Vue from "vue";
import Router from "vue-router";

import store from "./store/store";

Vue.use(Router);

const router = new Router({
    mode: "history",
    base: "/",
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("./layouts/main/Main.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/",
                    name: "home",
                    meta: {
                        requiresAuth: true,
                    },
                    component: () => import("./views/Home.vue"),
                },
                {
                    path: "/page2",
                    name: "page-2",
                    meta: {
                        requiresAuth: true,
                    },
                    component: () => import("./views/Page2.vue"),
                },
            ],
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("@/layouts/full-page/FullPage.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/dashboard",
                    name: "home",
                    meta: {
                        requiresAuth: true,
                    },
                    component: () => import("./views/Home.vue"),
                },
                // {
                //     path: "/page2",
                //     name: "page-2",
                //     component: () => import("./views/Page2.vue"),
                // },
                // =============================================================================
                // Reportes
                // =============================================================================
                {
                    path: "/reportes/inventario",
                    name: "reportes-inventario",
                    meta: {
                        requiresAuth: true,
                    },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesInventario.vue"
                        ),
                    meta: {
                        rule: "editor",
                    },
                },
                {
                    path: "/reportes/ventas",
                    name: "reportes-ventas",
                    meta: {
                        requiresAuth: true,
                    },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesVentas.vue"
                        ),
                    meta: {
                        rule: "admin",
                    },
                },
            ],
        },
        
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: "",
            component: () => import("@/layouts/full-page/FullPage.vue"),
            children: [
                {
                    path: "/login",
                    name: "login",
                    component: () => import("@/views/pages/Login.vue"),

                },
                // =============================================================================
                // PAGES
                // =============================================================================
                {
                    path: "/pages/error-404",
                    name: "page-error-404",
                    component: () => import("@/views/pages/Error404.vue"),
                },
            ],
        },
        // Redirect to 404 page, if no match found
        {
            path: "*",
            redirect: "/pages/error-404",
        },
    ],
});

router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById("loading-bg");
    if (appLoading) {
        appLoading.style.display = "none";
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (localStorage.getItem("token") != null) {
            // obtener usuario autenticado
            let user = JSON.parse(localStorage.getItem("userInfo"));
            store.dispatch("updateUserInfo", user);
            next();
        } else {
            next({ name: "login" });
        }
    } else {
        if(from.name == "login" && localStorage.getItem("token") != null) {
            next({ name: "home" });
        }else{
            next();
        }
    }
});

export default router;
