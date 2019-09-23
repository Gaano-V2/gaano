require('./bootstrap');

import Vue from 'vue';

//Add Ons
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import CarbonVue from 'carbon-vue';
import Toastr from 'vue-toastr';
import VModal from 'vue-js-modal';
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'


//Helpers
import {routes} from './routes';
import StoreData from './store';
import {initialize} from './helpers/authorization';

//Main Component
import MainApp from './components/MainApp';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(CarbonVue)
Vue.use(Toastr, { /* options */ });
Vue.use(VModal);
Vue.use(VueGoodTablePlugin);

require('vue-toastr/src/vue-toastr.scss');

Vue.component('pagination', require('laravel-vue-pagination'));


const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    routes,
    mode: 'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
      MainApp,
    }
});
