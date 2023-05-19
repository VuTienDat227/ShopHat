const admin = [
  {
    path: '/admin',
    component: () => import('../layouts/AdminLayout.vue'),
    children: [
      {
        path: 'user',
        name: 'admin-users',
        component: () => import('../pages/admin/index.vue'),
        meta: { isAdminRoute: true },
      },
    ],
  },
];
export default admin;
