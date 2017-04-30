import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'
import {store} from './store.js'

// Cashier/Store User
import Home from './components/pages/Home.vue'
import CustomerReg from './components/pages/CustomerReg.vue'
import CardDetails from './components/pages/CardDetails.vue'

// Admin User
import Login from './components/auth/Login.vue'
import Admin from './components/pages/admin/Admin.vue'
import ImportCard from './components/pages/admin/ImportCard.vue'
import Products from './components/pages/admin/Products.vue'
import PointsSetup from './components/pages/admin/PointsSetup.vue'
import RewardsSetup from './components/pages/admin/RewardsSetup.vue'

import NFCApp from './packages/nfcapp.js'
import Auth from './packages/auth.js'

import Modal from './components/partials/Modal.vue'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.use(NFCApp)
Vue.use(Auth)

Vue.component('modal', Modal)

axios.defaults.baseURL = 'http://localhost:9020/api'

// TODO: Uncomment for Production
// Vue.auth.isAuthenticated().then((result)=>{
//     if (result) {
//         let auth_token = JSON.parse(result)
//         axios.defaults.headers.common['Authorization'] = auth_token.value
//     }
// });

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/customer-reg',
            component: CustomerReg
        },
        {
            path: '/card-details',
            component: CardDetails
        },

        // ======= Admin Routes ======= //
        {
            path: '/admin',
            component: Admin,
            meta: {
                forAuth: true
            }
        },
        {
            path: '/products',
            component: Products,
            meta: {
                forAuth: true
            }
        },
        {
            path: '/import-card',
            component: ImportCard,
            meta: {
                forAuth: true
            }
        },
        {
            path: '/points-setup',
            component: PointsSetup,
            meta: {
                forAuth: true
            }
        },
        {
            path: '/rewards-setup',
            component: RewardsSetup,
            meta: {
                forAuth: true
            }
        },
        {
            path: '/login',
            component: Login
        }
    ]
})

// TODO: Uncomment for Production
// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.forAuth)) {
//         let is_auth = Vue.auth.isAuthenticated()
//         is_auth.then((result)=>{
//             if (!result) {
//                 next({
//                     path: '/login'
//                 })
//             } else {
//                 next()
//             }
//         });
//     } else {
//         next()
//     }
// })

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})
