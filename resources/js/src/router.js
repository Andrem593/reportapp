import Vue from "vue";
import Router from "vue-router";
import authCheck from "./middleware/auth-check";
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
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () => import("./views/Home.vue"),
                },
                {
                    path: "/dashboard",
                    name: "dashboard",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () => import("./views/Home.vue"),
                },
                {
                    path: "/page2",
                    name: "page-2",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () => import("./views/Page2.vue"),
                },
                {
                    path: "/reportes/carga-masiva",
                    name: "reportes-carga-masiva",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/admin/reportes/CargaMasiva.vue"),
                },
                {
                    path: "/reportes/inventario",
                    name: "reportes-inventario",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesInventario.vue"
                        ),
                },
                {
                    path: "/reportes/ventas",
                    name: "reportes-ventas",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesVentas.vue"
                        ),
                },
                {
                    path: "/reportes/ventas/operacion",
                    name: "reportes-ventas-operacion",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesVentasOperacion.vue"
                        ),
                },
                {
                    path: "/reportes/ventas/clasificacion",
                    name: "reportes-ventas-clasificacion",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import(
                            "./views/pages/admin/reportes/ReportesVentasClasificacion.vue"
                        ),
                },
                {
                    path: "/mantenimientos/tiendas",
                    name: "mantenimientos-tiendas",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/tiendas.vue"),
                },
                {
                    path: "/mantenimientos/tienda",
                    name: "mantenimientos-tienda",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/tiendaForm.vue"),
                },
                {
                    path: "/mantenimientos/inventario",
                    name: "inventario",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/inventario.vue"),
                },
                {
                    path: "/mantenimientos/venta",
                    name: "mantenimientos-venta",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/Venta.vue"),
                },
                {
                    path: "/usuarios/lista-usuarios",
                    name: "usuarios-lista-usuarios",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/usuarios.vue"),
                },
                {
                    path: "/usuarios/usuario",
                    name: "mantenimientos-usuarios",
                    meta: { requiresAuth: true, middleware: [authCheck] },
                    component: () =>
                        import("./views/pages/mantenimientos/usuarioForm.vue"),
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
        if (from.name == "login" && localStorage.getItem("token") != null) {
            next({ name: "home" });
        } else {
            next();
        }
    }

    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];
        const context = { to, from, next, store };

        return middleware[0]({ ...context });
    }
});

export default router;
