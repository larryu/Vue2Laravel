<template>
    <div id="user-list">
        <div class="main">
            <div class="container">
                <user-crud-modal></user-crud-modal>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="user-title">
                                    User list
                                </div>
                            </div>
                            <div id="userlist" class="panel-body table-responsive">
                                <user-list-table></user-list-table>
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
    import UserListView from './UserListView.vue'
    import UserListTable from './UserListTable.vue'
    import UserCrudModal from './UserCrudModal.vue'
    export default {
        data () {
            return {
            }
        },
        computed: {
            ...mapGetters({
                userNodes: 'allUserNodes',
            }),
            ...mapState({
                user: state => state.authUser,
            }),
        },
        created() {
            console.log('UserList vue Component created.');
//            this.$store.dispatch('setUserNodes')
//                .then((response) => {
//                    console.log('UserList vue created response=', response);
//                })
//                .catch((error) => {
//                    console.error('UserList vue created error=', error);
//                });
        },
        components: {
            'user-crud-modal': UserCrudModal,
            'user-list-view': UserListView,
            'user-list-table': UserListTable,
        },
        mounted() {
            console.log('UserList vue Component mounted.');
        },
        methods: {
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