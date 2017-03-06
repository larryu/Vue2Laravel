<template>
    <div class="tree-view">
        <table class="table table-hover table-striped table-responsive table-bordered table-condensed">
            <thead>
                <tr>
                    <td>
                        Role Name
                    </td>
                    <td>Parent Role Name</td>
                    <td>Comment</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(treeNode,index) in treeNodes">
                <td>{{ treeNode.name }}</td>
                <td>{{ treeNode.parent? treeNode.parent.name: '' }}</td>
                <td>{{ treeNode.comment }}</td>
                <td class="center">
                    <tree-view-actions :item="treeNode"
                                       :row-data="treeNode"
                                       :row-index="index"
                                       @onActions="onActions"
                                       :selectedRole = "selectedRole"
                    >
                    </tree-view-actions>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Vue from 'vue';
    import TreeItem from './TreeItem.vue'
    import CustomAction from './CustomActions.vue'
    import VueSweetAlert from 'vue-sweetalert'
    Vue.use(VueSweetAlert);

    export default {
        props: {
            treeNodes: {
                type: Object,
                default() { return null; }
            },
            selectedRole: {
                type: Object,
            }
        },
        data () {
            return {
            }
        },
        created() {
            console.log('TreeView Component created.')
        },
        updated() {
            console.log('TreeView Component updated.')
        },
        components: {
            'tree-view-actions': CustomAction,
        },
        mounted() {
            console.log('TreeView Component mounted.')
        },
        methods: {
            onActions(data) {
                console.log('onActions data=', data);
                let payload = {
                    isShow: true,
                    data: data
                };
                if (data.action === 'Delete')
                {
                    //
                    let swal = this.$swal;
                    let me = this;
                    this.$swal({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this role!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'cancel',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        allowOutsideClick: false
                    }).then(function() {
                        me.$store.dispatch('deleteRoleRequest', data.data)
                            .then((response) => {})
                            .catch((error) => {});
                    }, function (dismiss) {
                    });
                    return;
                }

                this.$store.dispatch('setShowModal', payload)
            }
        }
    }
</script>

<style lang="scss" src='sweetalert2/dist/sweetalert2.css' scoped>
</style>