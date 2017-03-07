import Vue from 'vue';
import * as api from './../../config';
import * as types from './../../mutation-types';

export default {
    state: {
        authenticated: false,
        name: null,
        email: null,
        role: null,
    },
    mutations: {
        [types.SET_AUTH_USER] (state, payload) {
            console.log('types.SET_AUTH_USER payload=', payload);
            console.log('types.SET_AUTH_USER state=', state);
            state.authenticated = true;
            state.name = payload.user.name;
            state.email = payload.user.email;
            state.role = payload.user.role;
        },
        [types.UNSET_AUTH_USER] (state, payload) {
            state.authenticated = false;
            state.name = null;
            state.email = null;
            state.role = null;
        }
    },
    actions: {
        setAuthUser: ({commit, dispatch}) => {
            console.log('setAuthUser');
            Vue.http.get(api.currentUser)
                .then(response => {
                    commit({
                        type: types.SET_AUTH_USER,
                        user: response.body
                    })
                })
                .catch(error => {
                    dispatch('logoutRequest');
                })
        },
        unsetAuthUser: ({commit}) => {
            commit({
                type: types.UNSET_AUTH_USER
            });
        }
    }
}