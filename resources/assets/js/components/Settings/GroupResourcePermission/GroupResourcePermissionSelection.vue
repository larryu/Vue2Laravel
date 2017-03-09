<template>
    <tr class="list-panel-row">
        <td width="60%">
            <div class="input-group-sm">
                <v-select
                        v-model="rowData.role"
                        :value="defaultRole"
                        :options="roleOptions"
                        @change="onRoleChanged">
                </v-select>
            </div>
        </td>
        <td width="40%">
            <div class="input-group-sm">
                <v-select
                        v-model="rowData.group"
                        :value="defaultGroup"
                        :options="groupOptions"
                        @change="onGroupChanged">
                </v-select>
            </div>
        </td>
        <td width="20%">
                <span class="btn btn-del btn-danger btn-sm" @click="onDelete(rowData, rowIndex)">
                    <span class="glyphicon glyphicon-trash"></span>
                </span>
        </td>
    </tr>
</template>

<script>
    import { mapState } from 'vuex'
    import select from 'vue-strap/src/Select'

    export default {
        components: {
            'v-select': select,
        },
        props: {
            currentRole: '',
            selectedRole: '',
            selectedGroup: '',
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number,
            },
        },
        computed: {
            ...mapState({
                user: state => state.authUser,
            }),
        },
        data () {
            return {
                defaultRole: '',
                defaultGroup: '',
                groupOptions: [],
                roleOptions: [],
                formData: [] ,
            }
        },
        created() {
            console.log('UserRoleGroupSelection created');
            console.log('UserRoleGroupSelection created selectedRole=', this.selectedRole);
            console.log('UserRoleGroupSelection created selectedGroup=', this.selectedGroup);
            // get all children roles based on selectedRole
            this.$store.dispatch('getRoleOptions', this.currentRole)
                .then((response) => {
                    console.log('getRoleOptions success=', response);
                    this.setRoleOptions(response.data.roles);
                })
                .catch((error) => {
                    console.error('getRoleOptions error=', error);
                });
        },
        methods: {
            setRoleOptions(roles) {
                let options = [];
                for (let role in roles) {
                    options.push({value: roles[role].name, label: roles[role].name});
                }
                this.roleOptions = options;
                this.defaultRole = this.selectedRole ? this.selectedRole : this.roleOptions[0].value;
            },
            setGroupOptions(groups) {
                if (!groups || groups.length == 0) return;
                let options = [];
                for (let group in groups) {
                    console.log('setRoleOptions role=', group);
                    options.push({value: groups[group].name, label: groups[group].name});
                }
                this.groupOptions = options;
                this.defaultGroup = this.selectedGroup ? this.selectedGroup : this.groupOptions[0].value;
            },
            onDelete(rowData, rowIndex) {
                console.log('UserRoleGroupSelection onDelete');
                console.log('UserRoleGroupSelection onDelete rowData=', rowData);
                console.log('UserRoleGroupSelection onDelete =rowIndex', rowIndex);
                this.$emit('onDelete', {action: 'delete', data: rowData, index: rowIndex});

            },
            onRoleChanged(selVal) {
                console.log('UserRoleGroupSelection onRoleChanged');
                this.groupOptions = [];
                this.defaultGroup = '';
                // whenever role changes, get the associated groups
                this.$store.dispatch('getGroupOptions', selVal)
                    .then((response) => {
                        console.log('getGroupOptions success=', response);
                        this.setGroupOptions(response.data.groups);
                    })
                    .catch((error) => {
                        console.error('getGroupOptions error=', error);
                    });
            },
            onGroupChanged() {
                console.log('UserRoleGroupSelection onGroupChanged')
            }
        }
    }
</script>
<style>
</style>