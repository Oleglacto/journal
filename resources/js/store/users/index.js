import axios from 'axios';
import {merge} from "lodash";

export default {
    state: {
        users: [],
        pref: '/api',
        GET: {
            users: '/users',
            user: '/users/{id}',
        },
        POST: {
            user: '/user',
        },
        DELETE: {
            user: '/users/{id}'
        },
        PATCH: {

        },
        PUT: {
            users: '/users/{id}',
        },
    },
    getters: {
        usersList(state) {
            return state.users;
        },
    },
    mutations: {
        addUser(store, users) {
            store.users = users;
        },
        addRoles(store, data) {
            store.roles = data;
        }
    },
    actions: {
        getUsers(context, data){

            console.log(data);

            let params = {
                params: data
            };

            axios.get(context.state.pref + context.state.GET.users, params)
                .then(response => {
                    context.commit('addUser', response.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },

        getUser(context, data) {
            return new Promise((resolve, reject) => {
                    axios.get(context.state.pref + context.state.GET.user.replace('{id}', data.id), {})
                        .then(response => {
                            resolve(response);
                        })
                        .catch((error) => {
                            reject(error);
                        });
                });
        },

        addUser(context, data) {
            axios.post(context.state.pref + context.state.POST.user, data)
                .then(response => response.data)
                .then(data => {
                    console.log(data);
                })

        }
    }
}