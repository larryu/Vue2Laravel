<template>
    <div class="modal fade" id="available-item-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog custom-class" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Role</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="row">
                            </div>
                            <div class="row">
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        components: {
        },
        mounted() {
            console.log('CrudRoleForm Component ready.')
        },
        data() {
            return {
            }
        },
        methods : {
            onActions(data) {
                console.log('onActions', data);
                if (data.action == 'add') {
                    this.addAction(data.data);
                }
            },
            addAction (data)
            {
                console.log('addAction', data);
                $("#av-list").modal('hide');
            },
        },
    }

</script>
<style>
    /*@media screen and (min-width: 768px) {*/
        /*.custom-class {*/
            /*width: 80%;*/
            /*!* either % (e.g. 60%) or px (400px) *!*/
        /*}*/
    /*}*/
</style>