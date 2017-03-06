<template>
    <div id="menu-list">
        <div class="main">
            <div class="container">
                <menu-crud-modal></menu-crud-modal>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="menu-title">
                                    Menu list
                                </div>
                            </div>
                            <div id="menulist" class="panel-collapse collapse in table-responsive">
                                <ul class="list-group">
                                    <li id="menus-list" class="list-group-item">
                                        <menu-list-view :menuNodes="menuNodes"></menu-list-view>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import { mapGetters, mapState, mapActions} from 'vuex'
    import MenuListView from './MenuListView.vue'
    import MenuCrudModal from './MenuCrudModal.vue'
    export default {
        data () {
            return {
            }
        },
        computed: {
            ...mapGetters({
                menuNodes: 'allMenuNodes',
            }),
            ...mapState({
                user: state => state.authUser,
            }),
        },
        created() {
            console.log('MenuList vue Component created.');
            this.$store.dispatch('setMenuNodes')
                .then((response) => {
                    console.log('MenuList vue created response=', response);
                })
                .catch((error) => {
                    console.error('MenuList vue created error=', error);
                });
        },
        components: {
            'menu-crud-modal': MenuCrudModal,
            'menu-list-view': MenuListView,
        },
        mounted() {
            console.log('MenuList vue Component mounted.');
        },
        methods: {
            parseJsObject(obj) {
                let result = {type: Object};
                for (let p in obj) {
                    if( obj.hasOwnProperty(p) ) {
                        result[p] = obj[p];
                    }
                }
                return result;
            }
        },
    }
</script>

<style scoped>
    .panel-primary > .panel-heading {
        color: white;
        background-color: #0a5b9e;
        border-color: #0a5b9e;
    }
    .panel-heading a {
        color: white;
    }
    .panel-heading .accordion-toggle:after {
        /* symbol for "opening" panels */
        font-family: 'Glyphicons Halflings';
        content: "\e114";
        float: right;
        color: white;
    }
    .panel-heading .accordion-toggle.collapsed:after {
        /* symbol for "collapsed" panels */
        content: "\e080";
    }
    .role-title {
        margin-left: 6px;
        height: 30px;
    }
</style>