<template>
    <div>
        <div class="grp-custom-actions text-center">
            <button v-if="actAdd" class="btn btn-primary" @click="itemAction('Add', rowData, rowIndex)" title="Add"><i class="glyphicon glyphicon-plus"></i></button>
            <button v-if="actEdit" class="btn btn-warning" @click="itemAction('Edit', rowData, rowIndex)" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>
            <button v-if="actDelete" class="btn btn-danger" @click="itemAction('Delete', rowData, rowIndex)" title="Delete"><i class="glyphicon glyphicon-remove"></i></button>
        </div>
    </div>
</template>
<script>
    export default {
        components: {
        },
        props: {
            item: {
                type: Object,
            },
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number,
            },
        },
        data () {
            return {
                actAdd: false,
                actEdit: {
                    type: Boolean,
                    default: true
                },
                actDelete: {
                    type: Boolean,
                    default: true
                },
            }
        },
        mounted() {
        },
        updated() {
            console.log('GroupResourcePermissionCustomActions Component updated.');
        },
        created() {
            console.log('GroupResourcePermissionCustomActions created: ', this.rowData, this.rowIndex);
        },
        methods: {
            itemAction (action, data, index) {
                console.log('itemAction: CustomAction:action-item :' + action, data, index);
                // emit event to let parent do things
                this.$parent.$emit('CustomAction:action-item', {action: action, data: data, index: index});
            },
        },
        watch: {
        }
    }
</script>

<style>
    .custom-actions button.ui.button {
        padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
        margin: auto !important;
    }
</style>