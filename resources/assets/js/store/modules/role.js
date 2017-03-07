
import Vue from 'vue';
import * as api from './../../config';
import * as types from './../../mutation-types';


export default {
    state: {
        roles: {
            assingedRoles: [],
            childRoles: [],
        },
        showModal: false,
        roleData: null,
        modalForm: {
            role: null,
        },
    },
    getters: {
        allRoles: state => state.roles,
    },
    mutations: {
        [types.ADD_ROLE_SUCCESS] (state, payload) {
            console.log('types.ADD_ROLE_SUCCESS payload=', payload);
        },
        [types.ADD_ROLE_FAILURE] (state, payload) {
            console.log('types.ADD_ROLE_FAILURE payload=', payload);
        },
        [types.UPDATE_ROLE_SUCCESS] (state, payload) {
            console.log('types.UPDATE_ROLE_SUCCESS payload=', payload);
        },
        [types.UPDATE_ROLE_FAILURE] (state, payload) {
            console.log('types.UPDATE_ROLE_FAILURE payload=', payload);
        },
        [types.DELETE_ROLE_SUCCESS] (state, payload) {
            console.log('types.DELETE_ROLE_SUCCESS payload=', payload);
        },
        [types.DELETE_ROLE_FAILURE] (state, payload) {
            console.log('types.DELETE_ROLE_FAILURE payload=', payload);
        },
        [types.SET_ROLES] (state, payload) {
            console.log('types.SET_ROLES payload=', payload);
            console.log('types.SET_ROLES state=', state);
            state.roles.assingedRoles = JSON.parse(payload.roles.assingedRoles);
            state.roles.childRoles = JSON.parse(payload.roles.childRoles);
        },
        [types.UNSET_ROLES] (state, payload) {
            console.log('types.UNSET_ROLES payload=', payload);
            console.log('types.UNSET_ROLES state=', state);
            state.roles.assingedRoles = [];
            state.roles.childRoles = [];
        },
        [types.SET_ROLE_SHOW_MODAL] (state, payload) {
            console.log('types.SET_ROLE_SHOW_MODAL payload=', payload.data);
            console.log('types.SET_ROLE_SHOW_MODAL state=', state);
            state.showModal = payload.data.isShow;
            state.roleData = payload.data.data;
        },
    },
    actions: {
        updateRoleRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                console.log('updateRoleRequest formData=',formData);
                Vue.http.post(api.updateRole, formData)
                    .then(response => {
                        dispatch('updateRoleSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('updateRoleFailure', response.body);
                        reject();
                    });
            })
        },
        updateRoleSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_ROLE_SUCCESS,
                role: body.role
            });
            dispatch('showSuccessNotification', 'Role has been updated.');
            dispatch('setRoles')
                .then((response) => {
                    console.log('updateRoleSuccess response=', response);
                })
                .catch((error) => {
                    console.log('updateRoleSuccess error=', error);
                });
        },
        updateRoleFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_ROLE_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        deleteRoleRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.deleteRole, formData)
                    .then(response => {
                        dispatch('deleteRoleSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('deleteRoleFailure', response.body);
                        reject();
                    });
            })
        },
        deleteRoleSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_ROLE_SUCCESS,
                role: body.role
            });
            dispatch('showSuccessNotification', 'Role has been deleted.');
            dispatch('setRoles')
                .then((response) => {
                    console.log('deleteRoleSuccess response=', response);
                })
                .catch((error) => {
                    console.log('deleteRoleSuccess error=', error);
                });
        },
        deleteRoleFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_ROLE_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        addRoleRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.addRole, formData)
                    .then(response => {
                        dispatch('addRoleSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        console.error('addRoleRequest response.body=', response.body);
                        dispatch('addRoleFailure', response.body);
                        reject();
                    });
            })
        },
        addRoleSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_ROLE_SUCCESS,
                role: body.role
            });
            dispatch('showSuccessNotification', 'Role has been added.');
            dispatch('setRoles')
                .then((response) => {
                    console.log('addRoleSuccess response=', response);
                })
                .catch((error) => {
                    console.log('addRoleSuccess error=', error);
                });
        },
        addRoleFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_ROLE_FAILURE,
                errors: body
            });
            console.error('addRoleFailure body.error=', body.error);
            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        setRoles: ({commit, dispatch}) => {
            console.log('setRoles');
            return new Promise((resolve, reject) => {
                Vue.http.get(api.currentRoles)
                    .then(response => {
                        commit({
                            type: types.SET_ROLES,
                            roles: response.body
                        });
                        resolve(response);
                    })
                    .catch(error => {
                        console.error('setRoles error =', error);
                        reject(error);
                    });
            });
        },
        unsetRoles: ({commit}) => {
            commit({
                type: types.UNSET_ROLES
            });
        },
        setRoleShowModal:({commit}, data) => {
            commit({
                type: types.SET_ROLE_SHOW_MODAL,
                data: data
            });
        },
    }
}