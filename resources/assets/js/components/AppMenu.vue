<template>
  <div id="appmenu">
    <header class="header">
        <div class="container">
            <!-- navbar -->
            <nav class="navbar navbar-blue">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand"> {{ projectName }}</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav"> 
                    <li v-for="menu in menus" :class="{'dropdown' : menu.children, 'disabled' : menu.permission === 'D'}" @click="clickOnLink(menu, $event)" >
                        <template v-if="!menu.children">
                            <router-link :to="menu.link" v-if="menu.permission !== 'H'">{{ menu.name }}</router-link>
                        </template>
                        <template v-else>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ menu.name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li v-for="submenu in menu.children" v-if="submenu.name !== 'Separator'"  @click="clickOnLink(submenu, $event)">
                                        <router-link :to="submenu.link"
                                                     v-if="submenu.permission !== 'H'"
                                                     :class="{'disabled' : submenu.permission === 'D'}">
                                            {{ submenu.name }}
                                        </router-link>
                                    </li>
                                    <li v-else role="separator" class="divider"></li>
                                </ul>
                        </template>
                        <!--<app-submenu :menu="menu"></app-submenu>-->
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right"  v-if="user.authenticated">
                    <li><a >{{ user.role }}</a></li>
                    <li><a >Hi {{ user.name }}</a></li>
                    <li><a href="#" @click.prevent="logout()">Logout</a></li>
                </ul>
                </div><!--/.nav-collapse -->
            </div>
            </nav>
        </div>
    </header>
  </div>
</template>

<script>
    
    import Vue from 'vue';
    import {mapGetters,mapState} from 'vuex'
    import {projectName} from './../config';

    export default {
        components:{
        },
        data() {
            return {
                projectName: projectName,
            }
        },
        beforeCreate() {
            console.log('AppMenu vue beforeCreated! start');
        },
        created() {
            console.log('AppMenu vue created! start');
            this.$store.dispatch('setMenus')
                .then((response) => {
                    console.log('AppMenu vue created response=', response);

                })
                .catch((error) => {
                    console.error('AppMenu vue created error=', error);
                });
        },
        mounted() {
            console.log('AppMenu Component mounted.')
        },            
        computed: {
            ...mapGetters({
                menus: 'allMenus',
            }),
            ...mapState({
                user: state => state.authUser,
            }),
        },
        methods: {
            logout() {
                this.$store.dispatch('logoutRequest')
                    .then(() => {
                        this.$router.push({name: 'login'});
                    });
            },
            clickOnLink(menu, event) {
                console.log('clickOnLink submenu=', menu);
                console.log('clickOnLink event.target=', event.target);
                if (menu.permission == 'D')
                {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            },
        },
        // watch: {
        //     menus () {
        //         console.log('menus changed menus=', this.menus);
        //     }
        // },
    }
</script>
<style scoped>

.header {
	background: #0a5b9e;
	color: #fff;
	box-shadow: 0px 3px 5px 0 rgba(0,0,0,0.3) inset;
}
.navbar-blue {
    margin-top:5px;
    padding: 5px 0;
    background: #0a5b9e;
    color:#fff;
}
.navbar-blue a {
    color: white;
}
.navbar {
    border-radius: 0px !important;
    margin-bottom: 0px !important;
}
.nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
    background-color:  rgb(109, 153, 191) !important;
    border-color: #337ab7 !important;
}
.navbar-blue a:hover, a:focus {
    background-color:  rgb(109, 153, 191) !important;
}
.dropdown-menu {
    background-color: #0a5b9e !important;
    color: white !important;
}
.dropdown-menu a {
    color: white !important;
}
.navbar-toggle .icon-bar {
    background-color: white !important;
}

a.disabled,
a.disabled:visited ,
a.disabled:active,
a.disabled:hover {
    color: #999 !important;
    cursor: no-drop;
}
.dropdown-menu {
    a.disabled,
    a.disabled:visited ,
    a.disabled:active,
    a.disabled:hover {
        color: #999 !important;
        background-color: white;
        cursor: no-drop;
    }
}
</style>