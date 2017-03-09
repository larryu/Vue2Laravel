<template>
    <div id="grp-list">
        <div class="main">
            <div class="container">
                <grp-crud-modal></grp-crud-modal>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="grp-title">
                                    <span class="pull-left">Assigned Roles:
                                        <v-select  id="selectRoles"
                                                   :value="selectedRole"
                                                   :options="currentAssignedRoles"
                                                   @change="onRoleChanged">
                                        </v-select>
                                    </span>
                                </div>
                            </div>
                            <div id="grplist" class="panel-body table-responsive">
                                <grp-list-table :selectedRole="selectedRole" ></grp-list-table>
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
    import GroupResourcePermissionTable from './GroupResourcePermissionTable.vue'
    import GroupResourcePermissionCrudModal from './GroupResourcePermissionCrudModal.vue'
    import select from 'vue-strap/src/Select'

    export default {
        data () {
            return {
                selectedRole: '',
            }
        },
        computed: {
            ...mapGetters({
                grpNodes: 'allGroupResourcePermissionNodes',
            }),
            ...mapState({
                user: state => state.authUser,
                roles: state => state.role.roles,
            }),
            currentAssignedRoles() {
                console.log('currentAssignedRoles = ', this.roles.assingedRoles);
                let options = [];
                for (let role in this.roles.assingedRoles) {
                    if (!this.selectedRole) this.selectedRole = this.roles.assingedRoles[role].name;
                    options.push({value: this.roles.assingedRoles[role].name, label: this.roles.assingedRoles[role].name});
                }
                console.log('options = ', options);
                return options;
            },
        },
        created() {
            console.log('GroupResourcePermissionList vue Component created.');

            this.$store.dispatch('setRoles')
                .then((response) => {
                    console.log('currentAssignedRoles vue created response=', response);
                })
                .catch((error) => {
                    console.log('currentAssignedRoles vue created error=', error);
                });

        },
        components: {
            'v-select': select,
            'grp-crud-modal': GroupResourcePermissionCrudModal,
            'grp-list-table': GroupResourcePermissionTable,
        },
        mounted() {
            console.log('GroupResourcePermissionList vue Component mounted.');
        },
        methods: {
            onRoleChanged(value)
            {
                console.log('onSelected=', value);
                this.selectedRole = value;
            },
        },
        watch: {
            selectedRole(newVal, oldVal) {
                console.log('watch selectedRole =', newVal, oldVal);
            }
        }
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
    .grp-title {
        margin-left: 6px;
        height: 30px;
    }
</style>