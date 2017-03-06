<template>
    <div>
        <div class="modal-mask" transiton="modal">
            <div class="modal-wrapper">
                <div class="modal-container" @click.stop>
                    <div class="modal-header">
                        <slot name="header">default header</slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button" @click="$emit('close')">OK</button>
                            <button class="modal-default-button" @click="$emit('close')">Cancel</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {}
        },
        created() {
            console.log('CustomModal Component created.')
        },
        components: {

        },
        mounted() {
            console.log('CustomModal Component mounted.')
        },
        methods: {
            close() {
            }
        }
    }
</script>

<style>
    .modal-mask {
        postion: fixed;
        z-index: 9998;
        top: 0;
        left:0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0, .5);
        display: table;
        transition: opacity.3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    .modal-container {
        width:300px;
        margin:0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0,0,0, .33);
        transiton: all .3s ease;
        font-family: Helvetia, Arial, sans-serif;
    }
    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }
    .modal-body {
        margin: 20px 0;
    }
    .modal-default-button {
        float: right;
    }
    .modal-enter {
        opacity: 0;
    }
    .modal-leave-active {

    }
</style>
