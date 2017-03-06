<template>
    <div id="user-list">
        <div class="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse"  href="#creditinfo">
                                    Users
                                </a>
                            </div>
                            <div id="userlist" class="panel-collapse collapse in table-responsive">
                                <table class="table table-hover table-striped table-responsive table-bordered table-condensed">
                                    <tbody>
                                    <tr>
                                        <td>Total Credit Amount</td>
                                        <td colspan="2">
                                        </td>
                                        <td class="center"><button type="button" class="btn btn-primary btn-xs">Edit</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import { mapGetters, mapState, mapActions} from 'vuex'

    export default {
        data () {
            return {}
        },
        ...mapState({
            users: state => state.users,
        }),
        created() {
            console.log('UserList vue Component created.')
            this.$store.dispatch('setUsers')
                .then((response) => {
                    console.log('UserList vue created response=', response);
                })
                .catch((error) => {
                    console.log('UserList vue created error=', error);
                });
        },
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
        },
        mounted() {
            console.log('App Component mounted.')
        }
    }
</script>

<style>
</style>
