<template>
    <div>
         <div class="custom-actions text-center">
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
                type: String,
            },
            selectedRole: {
                type: Object,
            }
        },
        data () {
            return {
                actAdd: {
                    type: Boolean,
                    default: true
                },
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
            console.log('custom-actions Component updated.');
        },
        created() {
            console.log('custom-actions created: ', this.rowData, this.rowIndex);
            if (this.rowData.id === 1) {
                // admin cannot be deleted or edit
                this.actDelete = false;
                this.actEdit = false;
            }
            else if (!this.selectedRole.canEdit)
            {
                this.actAdd = false;
                this.actDelete = false;
                this.actEdit = false;
            }
            else if (this.selectedRole.id === this.rowData.id)
            {
                this.actDelete = false;
                this.actEdit = false;
            }
        },
        methods: {
            itemAction (action, data, index) {
                console.log('itemAction: ' + action, data, index);
                // emit event to let parent do things
                this.$emit('onActions', {action: action, data: data, index: index});
            },
        },
        watch: {
            rowData(newVal, oldVal) {
                console.log('watch rowData=', oldVal, newVal);
                if (JSON.stringify(newVal) === JSON.stringify(oldVal)) return;
                if (newVal === oldVal) return;
                if (newVal.id === 1) {
                    // admin cannot be deleted or edit
                    this.actAdd = true;
                    this.actDelete = false;
                    this.actEdit = false;
                }
                else if (!this.selectedRole.canEdit)
                {
                    this.actAdd = false;
                    this.actDelete = false;
                    this.actEdit = false;
                }
                else if (this.selectedRole.id === newVal.id)
                {
                    this.actAdd = true;
                    this.actDelete = false;
                    this.actEdit = false;
                }
                else
                {
                    console.log('watch actAdd = false=');
                    this.actAdd = true;
                    this.actDelete = true;
                    this.actEdit = true;
                }
            }
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