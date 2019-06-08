import VueRouter from 'vue-router';
// Pages
import Home from './pages/Home';
import About from './pages/About';
import Register from './pages/Register';
import Login from './pages/Login';
import Index from './pages/user/Index';
import Dashboard from './pages/user/Dashboard';

import AdminIndex from './pages/admin/Index';
import AdminDashboard from './pages/admin/Dashboard';

// Routes
const routes = [
    {
        path: '/',
        redirect: '/home'
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/about',
        name: 'about',
        component: About,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // Admin ROUTES
    {
        path: '/admin/',
        name: 'admin',
        component: AdminIndex,
        meta: {
            auth: {
                roles: 1,
                redirect: { name: 'login' },
                forbiddenRedirect: '/403'
            }
        },
        children: [
            {
                path: '/admin/dashboard',
                name: 'admin.dashboard',
                component: AdminDashboard
            }
        ]
    },
    // USER ROUTES
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            auth: true
        },
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: Dashboard
            }
        ]
    }
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
    linkActiveClass: 'is-active'
});
export default router;
