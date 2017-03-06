
require('./bootstrap');

import router  from './router'
import store from './store/index';
import jwtToken from './helpers/jwt-token';

import AppMain   from './components/AppMain.vue'

Vue.component('appmain', AppMain)

Vue.http.interceptors.push((request, next) => {
    console.log('Vue.http.interceptors.push');
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    if(jwtToken.getToken()) {
        request.headers.set('Authorization', 'Bearer '+ jwtToken.getToken());
    }
    // show loading
    //store.dispatch('updateLoading', true);
    next((response) => {
        console.log('Vue.http.interceptors.push next response=', response);
        //store.dispatch('updateLoading', false);
        if(!response.ok && response.body.error 
            && (response.body.error === "token_invalid" || response.body.error === "token_expired" || response.body.error === 'token_not_provided')) {
                store.dispatch('logoutRequest')
                .then(()=> {
                    router.push({name: 'login'});
                });
        }
    });
});

const app = new Vue({
    el: '#app',
    router: router,
    store,
    render: app => app(AppMain)
});
