import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'
import {store} from './store.js'

import Home from './components/pages/Home.vue'
import CustomerReg from './components/pages/CustomerReg.vue'
import ImportCard from './components/pages/ImportCard.vue'
import CardDetails from './components/pages/CardDetails.vue'
import Products from './components/pages/Products.vue'

import NFCApp from './packages/nfcapp.js'
import Auth from './packages/auth.js'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.use(NFCApp)
Vue.use(Auth)

axios.defaults.baseURL = 'http://localhost:9020/api'

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
            path: '/import-card',
            component: ImportCard
        },
        {
            path: '/card-details',
            component: CardDetails
        },
        {
            path: '/products',
            component: Products
        }
    ]
})

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})
