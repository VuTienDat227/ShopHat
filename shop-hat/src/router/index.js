import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import ShopView from '../views/ShopView.vue';
import CartView from '../views/CartView.vue';
import CheckoutView from '../views/CheckoutView.vue';
import ProductDetailsView from '../views/ProductDetailsView.vue';
import LoginView from '../views/LoginView.vue';
import SignupView from '../views/SignupView.vue';
import ForgotPasswordView from '../views/ForgotPasswordView.vue';
import admin from './admin.js';
import Error from '../views/Error.vue';
import UserLayout from '../layouts/UserLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';
import AdminHome from '../pages/admin/index.vue';
import AdminProduct from '../pages/admin/product.vue';
import AdminCategory from '../pages/admin/category.vue';
import AdminBillInfo from '../pages/admin/billInfo.vue';
import AdminLogin from '../pages/admin/AdminLogin.vue';
import AboutUs from '../views/AboutUs.vue'
import axios from '@/axios';

const routers = [...admin];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: UserLayout,
            children: [
                {
                    path: '',
                    name: 'home',
                    component: HomeView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
                {
                    path: 'shop',
                    name: 'shop',
                    component: ShopView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
                {
                    path: 'error',
                    name: 'error',
                    component: Error,
                },
                {
                    path: 'Login',
                    name: 'Login',
                    component: LoginView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn !== null) {
                            next('/');
                        } else {
                            next();
                        }
                    },
                },
                {
                    path: 'checkout',
                    name: 'checkout',
                    component: CheckoutView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
                {
                    path: 'product-details/:id',
                    name:'ProductDetailsView',
                    component: ProductDetailsView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
                {
                    path: 'CartView',
                    name:'CartView',
                    component: CartView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                    props: true,
                },
                {
                    path: 'Signup',
                    name:'Signup',
                    component: SignupView,

                },
                {
                    path: 'ForgotPassword',
                    name:'ForgotPassword',
                    component: ForgotPasswordView,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
                {
                    path: 'AboutUs',
                    name:'AboutUs',
                    component: AboutUs,
                    beforeEnter: (to, from, next) => {
                        const isLoggedIn = localStorage.getItem('isLoggedIn');
                        if (isLoggedIn) {
                            next();
                        } else {
                            next('/Login');
                        }
                    },
                },
            ],
        },
        {
            path: '/admin',
            beforeEnter: (to, from, next) => {
                const userRoleId = localStorage.getItem('RoleId');
                if (userRoleId !== null && userRoleId !== undefined) {
                    if (userRoleId === '2') {
                        next();
                    } else {
                        next('/error');
                    }
                } else {
                    next('/AdminLogin');
                }
            },
            component: AdminLayout,
            children: [
                {
                    path: '',
                    name: 'homeAdmin',
                    component: AdminHome,
                },
                {
                    path: 'product',
                    component: AdminProduct,
                },
                {
                    path: 'category',
                    component: AdminCategory,
                },
                {
                    path: 'bill-info',
                    component: AdminBillInfo,
                },
            ],
        },
        {
            path: '/AdminLogin',
            name: 'AdminLogin',
            component: AdminLogin,
        },
        // Other routes...
    ].concat(routers),
});

export default router;