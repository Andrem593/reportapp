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
  // {
  //   url: '/page2',
  //   name: 'Page 2',
  //   slug: 'page2',
  //   icon: 'FileIcon'
  // },
  {
    url: null,
    name: 'Reportes',
    // tag: '2',
    // tagColor: 'warning',
    icon: 'PieChartIcon',
    i18n: 'Reportes',
    submenu: [
      {
        url: '/reportes/carga-masiva',
        name: 'Carga Masiva',
        icon: 'UploadIcon',
        slug: 'reportes-carga-masiva',
        i18n: 'Carga Masiva',
      },
      {
        url: '/reportes/inventario',
        name: 'Inventario',
        icon: 'BoxIcon',
        slug: 'reportes-inventario',
        i18n: 'Inventario',
      },
      {
        url: '/reportes/ventas',
        name: 'Ventas',
        icon: 'TrendingUpIcon',
        slug: 'reportes-ventas',
        i18n: 'Ventas',
      }
    ]
  },
]
