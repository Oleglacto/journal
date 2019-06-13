import Vue from 'vue'
import Vuex from 'vuex'
import lessons from './lessons/index';
import schedule from './schedule/index';
import users from './users/index';
import journal from './journal/index';
import axios from "axios";
import get from 'lodash/get';

Vue.use(Vuex);

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let store = new Vuex.Store({

    modules: {
        lessons,
        schedule,
        users,
        journal
    },

    state: {
        pref: '/api',
        serviceInfo: null,

        GET: {
            serviceInfo: '/service-info'
        },
    },
    getters: {
        rolesList(state) {
            return get(state, 'serviceInfo.data.roles', []);
        },
        groupList(state) {
            return get(state, 'serviceInfo.data.groups', []);
        }

    },
    actions: {
        getServiceInfo(context){
            if (context.state.serviceInfo) return;

            axios.get(context.state.pref + context.state.GET.serviceInfo)
                .then(response => {
                    context.commit('addServiceInfo', response.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },
    },

    mutations: {
        addServiceInfo(state, data) {
            state.serviceInfo = data;
        }
    }
});

export default store;
