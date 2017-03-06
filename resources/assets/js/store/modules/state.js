import Vue from 'vue';
import * as api from './../../config';
import * as types from './../../mutation-types';

export default {
    state: {
        stateNodes: null,
        showModal: false,
        stateData: null,
        modalForm: {
            state: null,
        },
    },
    getters: {
        allStateNodes: state => state.stateNodes
    },
    mutations: {
        [types.ADD_STATE_SUCCESS] (state, payload) {
            console.log('types.ADD_STATE_SUCCESS payload=', payload);
        },
        [types.ADD_STATE_FAILURE] (state, payload) {
            console.log('types.ADD_STATE_FAILURE payload=', payload);
        },
        [types.UPDATE_STATE_SUCCESS] (state, payload) {
            console.log('types.UPDATE_STATE_SUCCESS payload=', payload);
        },
        [types.UPDATE_STATE_FAILURE] (state, payload) {
            console.log('types.UPDATE_STATE_FAILURE payload=', payload);
        },
        [types.DELETE_STATE_SUCCESS] (state, payload) {
            console.log('types.DELETE_STATE_SUCCESS payload=', payload);
        },
        [types.DELETE_STATE_FAILURE] (state, payload) {
            console.log('types.DELETE_STATE_FAILURE payload=', payload);
        },
        [types.SET_STATE_NODES] (state, payload) {
            console.log('types.SET_STATE_NODES payload=', payload.stateNodes);
            console.log('types.SET_STATE_NODES state=', state);
            state.stateNodes = payload.stateNodes;
        },
        [types.UNSET_STATE_NODES] (state, payload) {
            console.log('types.UNSET_STATE_NODES payload=', payload);
            console.log('types.UNSET_STATE_NODES state=', state);
            state.stateNodes = null;
        },
        [types.SET_STATE_SHOW_MODAL] (state, payload) {
            console.log('types.SET_STATE_SHOW_MODAL payload=', payload.data);
            console.log('types.SET_STATE_SHOW_MODAL state=', state);
            state.showModal = payload.data.isShow;
            state.stateData = payload.data.data;
        },
    },
    actions: {
        updateStateRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                console.log('updateStateRequest formData=',formData);
                Vue.http.post(api.updateState, formData)
                    .then(response => {
                        dispatch('updateStateSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('updateStateFailure', response.body);
                        reject();
                    });
            })
        },
        updateStateSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_STATE_SUCCESS,
                state: body.state
            });
            dispatch('showSuccessNotification', 'State has been updated.');
            dispatch('setStateNodes');
        },
        updateStateFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_STATE_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        deleteStateRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.deleteState, formData)
                    .then(response => {
                        dispatch('deleteStateSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('deleteStateFailure', response.body);
                        reject();
                    });
            })
        },
        deleteStateSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_STATE_SUCCESS,
                state: body.state
            });
            dispatch('showSuccessNotification', 'State has been deleted.');
            dispatch('setStateNodes');
        },
        deleteStateFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_STATE_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        addStateRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.addState, formData)
                    .then(response => {
                        dispatch('addStateSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        console.error('addStateRequest response.body=', response.body);
                        dispatch('addStateFailure', response.body);
                        reject();
                    });
            })
        },
        addStateSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_STATE_SUCCESS,
                state: body.state
            });
            dispatch('showSuccessNotification', 'State has been added.');
            dispatch('setStateNodes');
        },
        addStateFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_STATE_FAILURE,
                errors: body
            });
            console.error('addStateFailure body.error=', body.error);
            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        setStateNodes: ({commit, dispatch}) => {
            console.log('setStateNodes');
            return new Promise((resolve, reject) => {
                Vue.http.get(api.currentStateNodes)
                    .then(response => {
                        console.log('setStateNodes gethttp success response.body=', response.body);
                        commit({
                            type: types.SET_STATE_NODES,
                            stateNodes: response.body.stateNodes
                        });
                        resolve(response);
                    })
                    .catch(error => {
                        console.error('setStateNodes error =', error);
                        reject(error);
                    });
            });
        },
        unsetStateNodes: ({commit}) => {
            commit({
                type: types.UNSET_STATE_NODES
            });
        },
        setStateShowModal:({commit}, data) => {
            commit({
                type: types.SET_STATE_SHOW_MODAL,
                data: data
            });
        },
    }
}