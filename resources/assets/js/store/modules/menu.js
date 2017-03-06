import Vue from 'vue';
import * as api from './../../config';
import * as types from './../../mutation-types';

export default {
    state: {
        menus: [],
        menuNodes: null,
        showModal: false,
        menuData: null,
        modalForm: {
            menu: null,
        },
    },
    getters: {
        allMenus: state => state.menus,
        allMenuNodes: state => state.menuNodes
    },
    mutations: {
        [types.ADD_MENU_SUCCESS] (state, payload) {
            console.log('types.ADD_MENU_SUCCESS payload=', payload);
        },
        [types.ADD_MENU_FAILURE] (state, payload) {
            console.log('types.ADD_MENU_FAILURE payload=', payload);
        },
        [types.UPDATE_MENU_SUCCESS] (state, payload) {
            console.log('types.UPDATE_MENU_SUCCESS payload=', payload);
        },
        [types.UPDATE_MENU_FAILURE] (state, payload) {
            console.log('types.UPDATE_MENU_FAILURE payload=', payload);
        },
        [types.DELETE_MENU_SUCCESS] (state, payload) {
            console.log('types.DELETE_MENU_SUCCESS payload=', payload);
        },
        [types.DELETE_MENU_FAILURE] (state, payload) {
            console.log('types.DELETE_MENU_FAILURE payload=', payload);
        },
        [types.SET_MENUS] (state, payload) {
            console.log('types.SET_MENUS payload=', payload.menus[0].children);
            console.log('types.SET_MENUS state=', state);
            state.menus = payload.menus[0].children;
        },
        [types.UNSET_MENUS] (state, payload) {
            console.log('types.UNSET_MENUS payload=', payload);
            console.log('types.UNSET_MENUS state=', state);            
            state.menus = [];
        },
        [types.SET_MENU_NODES] (state, payload) {
            console.log('types.SET_MENU_NODES payload=', payload.menuNodes);
            console.log('types.SET_MENU_NODES state=', state);
            state.menuNodes = payload.menuNodes;
        },
        [types.UNSET_MENU_NODES] (state, payload) {
            console.log('types.UNSET_MENU_NODES payload=', payload);
            console.log('types.UNSET_MENU_NODES state=', state);
            state.menuNodes = null;
        },
        [types.SET_MENU_SHOW_MODAL] (state, payload) {
            console.log('types.SET_MENU_SHOW_MODAL payload=', payload.data);
            console.log('types.SET_MENU_SHOW_MODAL state=', state);
            state.showModal = payload.data.isShow;
            state.menuData = payload.data.data;
        },
    },
    actions: {
        updateMenuRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                console.log('updateMenuRequest formData=',formData);
                Vue.http.post(api.updateMenu, formData)
                    .then(response => {
                        dispatch('updateMenuSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('updateMenuFailure', response.body);
                        reject();
                    });
            })
        },
        updateMenuSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_MENU_SUCCESS,
                menu: body.menu
            });
            dispatch('showSuccessNotification', 'Menu has been updated.');
            dispatch('setMenus');
            dispatch('setMenuNodes');
        },
        updateMenuFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.UPDATE_MENU_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        deleteMenuRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.deleteMenu, formData)
                    .then(response => {
                        dispatch('deleteMenuSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        dispatch('deleteMenuFailure', response.body);
                        reject();
                    });
            })
        },
        deleteMenuSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_MENU_SUCCESS,
                menu: body.menu
            });
            dispatch('showSuccessNotification', 'Menu has been deleted.');
            dispatch('setMenus');
            dispatch('setMenuNodes');
        },
        deleteMenuFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.DELETE_MENU_FAILURE,
                errors: body
            });

            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        addMenuRequest: ({dispatch}, formData) => {
            return new Promise((resolve, reject) => {
                Vue.http.post(api.addMenu, formData)
                    .then(response => {
                        dispatch('addMenuSuccess', response.body);
                        resolve();
                    })
                    .catch(response => {
                        console.error('addMenuRequest response.body=', response.body);
                        dispatch('addMenuFailure', response.body);
                        reject();
                    });
            })
        },
        addMenuSuccess: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_MENU_SUCCESS,
                menu: body.menu
            });
            dispatch('showSuccessNotification', 'Menu has been added.');
            dispatch('setMenus');
            dispatch('setMenuNodes');
        },
        addMenuFailure: ({commit, dispatch}, body) => {
            commit({
                type: types.ADD_MENU_FAILURE,
                errors: body
            });
            console.error('addMenuFailure body.error=', body.error);
            if(body.error) {
                dispatch('showErrorNotification', body.error);
            }
        },
        setMenuNodes: ({commit, dispatch}) => {
            console.log('setMenuNodes');
            return new Promise((resolve, reject) => {
                Vue.http.get(api.currentMenuNodes)
                    .then(response => {
                        console.log('setMenuNodes gethttp success response.body=', response.body);
                        commit({
                            type: types.SET_MENU_NODES,
                            menuNodes: response.body.menuNodes
                        });
                        resolve(response);
                    })
                    .catch(error => {
                        console.error('setMenuNodes error =', error);
                        reject(error);
                    });
            });
        },
        unsetMenuNodes: ({commit}) => {
            commit({
                type: types.UNSET_MENU_NODES
            });
        },
        setMenus: ({commit, dispatch}) => {
            console.log('setMenus');
            return new Promise((resolve, reject) => {
                Vue.http.get(api.currentMenus)
                    .then(response => {
                        console.log('setMenus gethttp success response.body=', response.body);
                        commit({
                            type: types.SET_MENUS,
                            menus: response.body.menus
                        });
                        resolve(response);
                    })
                    .catch(error => {
                        console.error('setMenus error =', error);
                        reject(error);
                    });
            });
        },
        unsetMenus: ({commit}) => {
            commit({
                type: types.UNSET_MENUS
            });
        },
        setMenuShowModal:({commit}, data) => {
            commit({
                type: types.SET_MENU_SHOW_MODAL,
                data: data
            });
        },
    }
}