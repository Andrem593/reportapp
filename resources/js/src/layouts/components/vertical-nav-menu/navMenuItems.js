/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: '/dashboard',
    name: 'Home',
    slug: 'home',
    icon: 'HomeIcon'
  },
  {
    url: null,
    name: 'Mantenimientos',
    icon: 'SettingsIcon',
    submenu: [
      {
        url: '/mantenimientos/tiendas',
        name: 'Tiendas',
        icon: 'StoreIcon',
        slug: 'tiendas',
      },
      {
        url: '/mantenimientos/inventario',
        name: 'Carga - Inventario',        
        slug: 'inventario',
      },
      {
        url: '/mantenimientos/venta',
        name: 'Carga - Venta',        
        slug: 'mantenimientos-venta',
      },
    ]
  },
  {
    url: null,
    name: 'Reportes',
    // tag: '2',
    // tagColor: 'warning',
    icon: 'PieChartIcon',
    i18n: 'Reportes',
    submenu: [
      {
        url: '/reportes/inventario',
        name: 'Existencia de Inventario',
        icon: 'BoxIcon',
        slug: 'reportes-inventario',
        i18n: 'Inventario',
      },
      {
        url: '/reportes/ventas',
        name: 'Ventas - Marca',
        icon: 'TrendingUpIcon',
        slug: 'reportes-ventas',
        i18n: 'Ventas',
      },
      {
        url: '/reportes/ventas/operacion',
        name: 'Ventas - Operacion',
        icon: 'TrendingUpIcon',
        slug: 'reportes-ventas-operacion',
        i18n: 'Ventas',
      },
      {
        url: '/reportes/ventas/clasificacion',
        name: 'Ventas - Clasificacion',
        icon: 'TrendingUpIcon',
        slug: 'reportes-ventas-clasificacion',
        i18n: 'Ventas',
      },
    ]
  },
]
