import Vue from 'vue';
import * as api from './../../config';
import jwtToken from './../../helpers/jwt-token';
import * as types from './../../mutation-types';

export default {
    state: {
        errors: {
            email: null,
            password: null
        }
    },
    mutations: {
        [types.LOGIN_SUCCESS] (state, payload) {
            state.errors.email = null;
            state.errors.passwor = null;
        },
        [types.LOGIN_FAILURE] (state, payload) {
            state.errors.email = payload.errors.email ? payload.errors.email[0] : null;
            state.errors.password = payload.errors.password ? payload.errors.password[0] : null;
        },
        [types.CLEAR_LOGIN_ERRORS] (state, payload) {
            state.errors.email = null;
            state.errors.password = null;
        }
    },
    actions: {
        loginRequest: ({dispatch}, formData) => {
            console.log('loginRequest');
            return new Promise((resolve, reject) => {
                Vue.http.post(api.login, formData)
                    .then(response => {
                        dispatch('loginSuccess', response.body);
                        resolve(response);
                    })
                    .catch(response => {
                        console.log('loginRequest error=', response);
                        dispatch('loginFailure', response.body);
                        reject(response);
                    });
            });
        },
        loginSuccess: ({commit, dispatch}, jwtTokenObj) => {
            console.log('loginSuccess jwtTokenObj=', jwtTokenObj);
            jwtToken.setToken(jwtTokenObj.token);
            commit({
                type: types.LOGIN_SUCCESS
            });

            dispatch('setAuthUser');
        },
        loginFailure: ({commit, dispatch}, body) => {
            console.log('loginFailure body=', body);
            commit({
                type: types.LOGIN_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        clearLoginErrors: ({commit}) => {
            commit({
                type: types.CLEAR_LOGIN_ERRORS
            });
        },
        logoutRequest: ({dispatch}) => {
            jwtToken.removeToken();

            return new Promise((resolve, reject) => {
                dispatch('unsetAuthUser');
                dispatch('unsetRoles');
                dispatch('unsetMenus');

                resolve();
            });
        }
    }
}