<template>
    <div id="user-role-group-selection" class="form-group">
        <div class="role-group-panel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a>
                        <strong>Role | Group</strong>
                    </a>
                    <span class="btn btn-del btn-primary btn-xs pull-right" title="New" @click="onClickNew()">
                            <span class="glyphicon glyphicon-plus"></span>
                            NEW
                    </span>
                </div>
                <div class="list-div table-responsive">
                <table class="table table-condensed">
                    <thead><tr><th>Role </th><th>Group</th></tr></thead>
                    <tbody>
                    <tr class="list-panel-row" item_id="">
                        <td>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="109"></option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="109"></option>
                                </select>
                                <span class="btn btn-del btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData: [] ,
            }
        },
        methods: {
            onClickNew() {
                console.log('UserRoleGroupSelection onClickNew')
            }
        }
    }
</script>
<style>

</style>