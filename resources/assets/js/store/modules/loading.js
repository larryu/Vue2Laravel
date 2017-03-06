import * as types from './../../mutation-types';

export default {
    state: {
        isLoading: false,
    },
    mutations: {
        [types.UPDATE_LOADING] (state, payload) {
            console.log('mutations UPDATE_LOADING payload=', payload);
            state.isLoading = payload.isLoading;
        },
    },
    actions: {
        updateLoading({commit}, data) {
            console.log('actions updateLoading data=', data);
            commit({
                type: types.UPDATE_LOADING,
                isLoading: data
            });
        },
    }
}