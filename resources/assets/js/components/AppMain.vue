<template>
  <div id="appmain" >
    <div id="mainbody" >
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
    <div id="mainfooter">
        <app-footer></app-footer>
    </div>
  </div>
</template>

<script>
    import AppFooter from './AppFooter.vue'
    import jwtToken from './../helpers/jwt-token';
    import * as api from './../config'
    import * as types from './../mutation-types';

    export default {
        created() {
            console.log('AppMain vue created store=', this.$store);
            if(jwtToken.getToken()) {
                this.$store.dispatch('setAuthUser');
            }
        },
        components: {
            'app-footer': AppFooter,
        },
        data () {
            return {
                store:  this.$store,
            }
        }
    }
</script>
<style lang="">

</style>