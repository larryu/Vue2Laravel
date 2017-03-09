import Vue from 'vue';
import * as api from './../../config';
import * as types from './../../mutation-types';

export default {
    state: {
        userNodes: null,
        showModal: false,
        userData: null,
        modalForm: {
            user: null,
        },
    },
    getters: {
        allUserNodes: state => state.userNodes
    },
    mutations: {
        [types.ADD_USER_SUCCESS] (state, payload) {
            console.log('types.ADD_USER_SUCCESS payload=', payload);
        },
        [types.ADD_USER_FAILURE] (state, payload) {
            console.log('types.ADD_USER_FAILURE payload=', payload);
        },
        [types.UPDATE_USER_SUCCESS] (state, payload) {
            console.log('types.UPDATE_USER_SUCCESS payload=', payload);
        },
        [types.UPDATE_USER_FAILURE] (state, payload) {
            console.log('types.UPDATE_USER_FAILURE payload=', payload);
        },
        [types.DELETE_USER_SUCCESS] (state, payload) {
            console.log('types.DELETE_USER_SUCCESS payload=', payload);
        },
        [types.DELETE_USER_FAILURE] (state, payload) {
            console.log('types.DELETE_USER_FAILURE payload=', payload);
        },
        [types.SET_USER_NODES] (state, payload) {
            console.log('types.SET_USER_NODES payload=', payload.userNodes);
            console.log('types.SET_USER_NODES state=', state);
            state.userNodes = payload.userNodes;
        },
        [types.UNSET_USER_NODES] (state, payload) {
            console.log('types.UNSET_USER_NODES payload=', payload);
            console.log('types.UNSET_USER_NODES state=', state);
            state.userNodes = null;
        },
        [types.SET_USER_SHOW_MODAL] (state, payload) {
            console.log('types.SET_USER_SHOW_MODAL payload=', payload.data);
            console.log('types.SET_USER_SHOW_MODAL state=', state);
            state.showModal = payload.data.isShow;
            state.userData = payload.data.data;
        },
    },
    actions: {
        updateUserRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                console.log('updateUserRequest formData=',formData);
                Vue.http.post(api.updateUser, formData)
                    .then(response => {
                        dispatch('updateUserSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('updateUserFailure', response.body);
                        reject();
                    });
            })
        },
        updateUserSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_USER_SUCCESS,
                user: body.user
            });
            dispatch('showSuccessNotification', 'User has been updated.');
            // dispatch('setUserNodes');
        },
        updateUserFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_USER_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        deleteUserRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.deleteUser, formData)
                    .then(response => {
                        dispatch('deleteUserSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('deleteUserFailure', response.body);
                        reject();
                    });
            })
        },
        deleteUserSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_USER_SUCCESS,
                user: body.user
            });
            dispatch('showSuccessNotification', 'User has been deleted.');
            //dispatch('setUserNodes');
        },
        deleteUserFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_USER_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        addUserRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.addUser, formData)
                    .then(response => {
                        dispatch('addUserSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        console.error('addUserRequest response.body=', response.body);
                        dispatch('addUserFailure', response.body);
                        reject();
                    });
            })
        },
        addUserSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_USER_SUCCESS,
                user: body.user
            });
            dispatch('showSuccessNotification', 'User has been added.');
            //dispatch('setUserNodes');
        },
        addUserFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_USER_FAILURE,
                errors: body
            });
            console.error('addUserFailure body.error=', body.error);
            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        setUserNodes: ({commit, dispatch}) => {
            console.log('setUserNodes');
            return new Promise((resolve, reject) => {
                Vue.http.get(api.currentUserNodes)
                    .then(response => {
                        console.log('setUserNodes gethttp success response.body=', response.body);
                        commit({
                            type: types.SET_USER_NODES,
                            userNodes: response.body.userNodes
                        });
                        resolve(response);
                    })
                    .catch(error => {
                        console.error('setUserNodes error =', error);
                        reject(error);
                    });
            });
        },
        unsetUserNodes: ({commit}) => {
            commit({
                type: types.UNSET_USER_NODES
            });
        },
        setUserShowModal:({commit}, data) => {
            commit({
                type: types.SET_USER_SHOW_MODAL,
                data: data
            });
        },
        getRoleOptions: ({dispatch}, selectedRole) => {
            return new Promise((resolve, reject) => {
                console.log('getRoleOptions selectedRole=',selectedRole);
                Vue.http.get(api.roleOptions + '?selectedRole=' + selectedRole)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(response => {
                        reject(response);
                    });
            })
        },
        getGroupOptions: ({dispatch}, selectedRole) => {
            return new Promise((resolve, reject) => {
                console.log('getGroupOptions selectedRole=',selectedRole);
                Vue.http.get(api.groupOptions + '?selectedRole=' + selectedRole)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(response => {
                        reject(response);
                    });
            })
        },
    }
}