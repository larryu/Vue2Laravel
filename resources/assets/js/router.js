import Vue from 'vue';
import VueRouter from 'vue-router';
import jwtToken from './helpers/jwt-token';
import Store from './store/index'

import HomeView from './components/Home.vue';
import DashboardView from './components/Dashboard.vue';
import RegisterView from './components/Register.vue';
import LoginView from './components/Login.vue';
import NotFoundView from './components/404.vue'
import OrderDetailsView from './components/OrderDetails/OrderDetails.vue'
import ItemsView from './components/Items/Items.vue'
import RoleListView from './components/Settings/Role/RoleList.vue'
import MenuListView from './components/Settings/Menu/MenuList.vue'
import StateListView from './components/Settings/State/StateList.vue'
import UserListView from './components/Settings/User/UserList.vue'
import GroupResourcePermissionListView from './components/Settings/GroupResourcePermission/GroupResourcePermissionList.vue'

let routes = [
    { path: '/login', component: LoginView, name: 'login', meta: { requiresGuest: true } },
    { path: '/register', component: RegisterView, name: 'register', meta: {} },
    { path: '/', component: HomeView, meta: { requiresAuth: true }, 
        children: [
            { path: '/users', component: UserListView,  meta: { requiresAuth: true }},
            { path: '/roles', component: RoleListView,  meta: { requiresAuth: true }},
            { path: '/menus', component: MenuListView,  meta: { requiresAuth: true }},
            { path: '/states', component: StateListView,  meta: { requiresAuth: true }},
            { path: '/groupresourcepermission', component: GroupResourcePermissionListView,  meta: { requiresAuth: true }},
            { path: '', component: DashboardView, name: 'dashboard', meta: { requiresAuth: true },
                children: [
                    // { path: '/dashboard', redirect: {name: 'orderdetails'}, meta: { requiresAuth: true } },
                    { path: '/orderdetails', name: 'orderdetails', component: OrderDetailsView, meta: { requiresAuth: true } },
                    { path: '/items', component: ItemsView, meta: { requiresAuth: true } },
                ]
            },

        ]
    },

    { path: '*', component: NotFoundView, meta: {} },  
];

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: routes,
    // linkActiveClass: 'active'
    scrollBehavior: function (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    console.log('router.beforeEach Store.state.authUser.authenticated=', Store.state.authUser.authenticated);
    // console.log('router.beforeEach from=', from);
    // console.log('router.beforeEach to=', to);
    Store.dispatch('hideErrorNotification');
    
    if(to.meta.requiresAuth) {
        // console.log('router.beforeEach to.meta.requiresAuth=', to.meta.requiresAuth);
        // console.log('router.beforeEach authenticated=', Store.state.authUser.authenticated);
        // console.log('router.beforeEach getToken=', jwtToken.getToken());
        if(Store.state.authUser.authenticated || jwtToken.getToken())
            return next();
        else
            return next({name: 'login'});
    }
    if(to.meta.requiresGuest) {
        // console.log('router.beforeEach to.meta.requiresGuest=', to.meta.requiresGuest);
        // console.log('router.beforeEach authenticated=', Store.state.authUser.authenticated);
        // console.log('router.beforeEach getToken=', jwtToken.getToken());
        if(Store.state.authUser.authenticated || jwtToken.getToken())
            return next({name: 'dashboard'});
        else
            return next();
    }
    next();
});

export default router;